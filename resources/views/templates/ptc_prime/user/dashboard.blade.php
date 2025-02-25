@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
        $themeColor = $general->theme_color ?? '#007bff';
    @endphp
    <div class="row g-3 mb-3">
        @if (auth()->user()->kv == 0)
            <div class="col-12">
                <div class="alert alert-info text-center p-3 border-0 shadow-sm">
                    <h6 class="mb-1 fw-bold">@lang('KYC Verification Required')</h6>
                    <p class="mb-0 small">
                        {{ __($kycInfo->data_values->verification_content) }}
                        <a href="{{ route('user.kyc.form') }}" class="fw-bold text-primary">@lang('Click Here to Verify')</a>
                    </p>
                </div>
            </div>
        @elseif(auth()->user()->kv == 2)
            <div class="col-12">
                <div class="alert alert-warning text-center p-3 border-0 shadow-sm">
                    <h6 class="mb-1 fw-bold">@lang('KYC Verification Pending')</h6>
                    <p class="mb-0 small">
                        {{ __($kycInfo->data_values->pending_content) }}
                        <a href="{{ route('user.kyc.data') }}" class="fw-bold text-primary">@lang('See KYC Data')</a>
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('user.ptc.confirm') }}" method="POST" onsubmit="return {{$earningClaimed ? 'false' : 'true'}};">
            @csrf
            <button type="submit" class="btn fw-bold claim-btn" id="{{ $earningClaimed ? 'counter' : '' }}">
                <i class="fas fa-coins me-1"></i> @lang('Claim Daily Earning')
            </button>
        </form>

    </div>
    <div class="row g-3">
        @foreach ([
            ['route' => 'transactions', 'label' => 'Available Balance', 'value' => showAmount($user->balance) . ' ' . __($general->cur_text), 'icon' => 'fas fa-wallet'],
            ['route' => 'transactions?search=&trx_type=%2B&remark=', 'label' => 'Today Earnings', 'value' => showAmount($dailyEarning) . ' ' . __($general->cur_text), 'icon' => 'fas fa-calendar-day'],
            ['route' => 'transactions?search=&trx_type=%2B&remark=', 'label' => 'Total Earnings', 'value' => showAmount($user->total_earning) . ' ' . __($general->cur_text), 'icon' => 'fas fa-dollar-sign'],
            ['route' => 'commissions', 'label' => 'Referral Earnings', 'value' => $commissionCount . ' ' . __($general->cur_text), 'icon' => 'fas fa-user-friends'],
            ['route' => 'transactions?search=&trx_type=&remark=subscribe_plan', 'label' => 'Total Investment', 'value' => showAmount($user->total_investment) . ' ' . __($general->cur_text), 'icon' => 'fas fa-chart-line'],
            ['route' => 'deposit/history', 'label' => 'Total Deposits', 'value' => showAmount($user->deposits->where('status', 1)->sum('amount')) . ' ' . __($general->cur_text), 'icon' => 'fas fa-university'],
            ['route' => 'withdraw/history', 'label' => 'Total Withdrawn', 'value' => showAmount($user->withdrawals->where('status', 1)->sum('amount')) . ' ' . __($general->cur_text), 'icon' => 'fas fa-money-bill-wave'],
            ['route' => 'referred-users/b&c', 'label' => 'My Plan', 'value' => optional($user->plan)->name ?? 'No Plan' , 'icon' => 'fas fa-star'],
            ['route' => 'referred-users', 'label' => 'Direct Members', 'value' => $user->reffer->count() . ' User(s)', 'icon' => 'fas fa-users'],
            ['route' => 'referred-users/b&c', 'label' => 'Total Team', 'value' => $refferUsers . ' User(s)', 'icon' => 'fas fa-network-wired'],
        ] as $stat)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card stats-card shadow-sm border-0 p-3 text-center"
                    onclick="window.location.href='{{ $stat['route'] }}'" style="cursor: pointer;">
                    <div class="icon-container" style="background: {{ $themeColor }};">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <p class="small text-muted mb-1">{{ __($stat['label']) }}</p>
                    <h6 class="fw-bold mb-0">{{ $stat['value'] }} </h6>
                </div>
            </div>
        @endforeach
    </div>
    @if ($general->notification_modal)
        <div class="modal fade" id="notificationModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="modal-header bg-gradient text-white py-4"
                        style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                        <h5 class="modal-title fw-bold">🚀 @lang('Important Notification')</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 text-center" style="max-height: 400px; overflow-y: auto;">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-container mb-4"
                                style="width: 70px; height: 70px; background: #6a11cb; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                <i class="fas fa-bell text-white" style="font-size: 48px;"></i>
                            </div>
                            <p class="lead text-dark mb-4">{!! __($general->modal_text) !!}</p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center bg-light">
                        <button type="button" class="btn btn-primary rounded-pill px-5 py-3 fw-bold"
                            data-bs-dismiss="modal">@lang('Got It!')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('style')
    <style>
        .claim-btn {
            background: linear-gradient(135deg, {{ $themeColor }}, #ff8c00);
            border: none;
            color: white;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 6px;
            transition: 0.3s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .claim-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ff8c00, {{ $themeColor }});
        }

        .stats-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease-in-out;
        }

        .stats-card:hover {
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
            transform: scale(1.03);
        }

        .icon-container {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #ffffff;
            font-size: 20px;
            margin: 0 auto 8px;
        }

        .modal-content {
            animation: slideDown 0.6s ease-out, glow 1.5s infinite alternate;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 15px #6a11cb;
            }

            to {
                box-shadow: 0 0 25px #2575fc;
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: scale(1.1);
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background-color: #6a11cb;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let modal = new bootstrap.Modal(document.getElementById("notificationModal"));
            let lastClosed = localStorage.getItem("modalLastClosed");
            if (!lastClosed || (Date.now() - lastClosed > 7200000)) {
                modal.show();
            }
            document.getElementById("notificationModal").addEventListener("hidden.bs.modal", function() {
                localStorage.setItem("modalLastClosed", Date.now().toString());
            });
        });

        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes +
                    "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{ __('COMPLETE') }}";
                }
                tms--;
            }, 1000);
        }
        createCountDown('counter', {{ \Carbon\Carbon::tomorrow()->diffInSeconds() }});
    </script>
@endpush

{{-- @extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
    @endphp

    <div class="row g-4 g-lg-3 g-xxl-4 mb-4">
        @if (auth()->user()->kv == 0)
            <div class="col-md-12">
                <div class="alert alert-info kyc-alert" role="alert">
                    <h5 class="alert-heading mt-0">@lang('KYC Verification required')</h5>
                    <hr>
                    <p class="mb-0">{{ __($kycInfo->data_values->verification_content) }} <a
                            href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
                    </p>
                </div>
            </div>
        @elseif(auth()->user()->kv == 2)
            <div class="col-md-12">
                <div class="alert alert-warning kyc-alert" role="alert">
                    <h5 class="alert-heading mt-0">@lang('KYC Verification pending')</h5>
                    <hr>
                    <p class="mb-0">
                        {{ __($kycInfo->data_values->pending_content) }}
                        <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-end mb-1 ">
        <form action="{{ route('user.ptc.confirm') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success"
                style="border-radius: 5px; font-weight: bold; font-size: 14px;">
                <i class="fas fa-coins"></i> @lang('Claim Daily Earning')
            </button>
        </form>
    </div>

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="row gy-4 dashboard-widget-wrapper">
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/credit.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.transactions') }}" class="dashboard-widget__text"> @lang('Available Balance')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->balance) }} {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/credit.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.transactions') }}" class="dashboard-widget__text"> @lang('Total Earning')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->total_earning) }} {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/credit.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.transactions') }}" class="dashboard-widget__text"> @lang('Total Investment')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->total_investment) }} {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb">
                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/withdrawal.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.withdraw.history') }}" class="dashboard-widget__text">
                                @lang('Total Withdraw') </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->withdrawals->where('status', 1)->sum('amount')) }}
                                    {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/credit.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.deposit.history') }}" class="dashboard-widget__text"> @lang('Total Deposits')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->deposits->where('status', 1)->sum('amount')) }}
                                    {{ $general->cur_text }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/plan.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text"> @lang('My Plan') </span>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    @if ($user->plan)
                                        {{ __($user->plan->name) }}
                                    @else
                                        @lang('No Plan')
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/referral-commission.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.commissions') }}" class="dashboard-widget__text"> @lang('Referral Commissions')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ __($commissionCount) }} {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/reminder-click.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text"> @lang('Next Reminder') </span>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    <div class="dashboard-widget__content">
                                        <h4 class="dashboard-widget__amount timer" id="counter"></h4>
                                    </div>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/referral-commission.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.referred') }}" class="dashboard-widget__text"> @lang('Referred User')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ $user->reffer->count() }} User
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/referral-commission.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.referredBC') }}" class="dashboard-widget__text"> @lang('B&C Users')
                            </a>
                            <div
                                class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ $refferUsers }} User
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($general->notification_modal)
        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">@lang('Notification')</h5>
                        <button type="button" class="btn-close" id="closeModalBtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body overflow-auto" style="max-height: 80vh;">
                        <p>{!! __($general->modal_text) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let modalElement = document.getElementById("notificationModal");
            let closeModalBtn = document.getElementById("closeModalBtn");

            let modal = new bootstrap.Modal(modalElement);
            let modalLastClosed = localStorage.getItem("modalLastClosed");
            let lastClosedTime = modalLastClosed ? parseInt(modalLastClosed) : 0;
            if (!lastClosedTime || (Date.now() - lastClosedTime > 7200000)) {
                modal.show();
            }
            modalElement.addEventListener("hidden.bs.modal", function() {
                localStorage.setItem("modalLastClosed", Date.now().toString());
            });
            if (closeModalBtn) {
                closeModalBtn.addEventListener("click", function() {
                    modal.hide();
                });
            }
        });
    </script>
    <script>
        (function($) {
            "use strict";
            var options = {
                series: [{
                    name: 'Clicks',
                    data: [
                        @foreach ($chart['click'] as $key => $click)
                            {{ $click }},
                        @endforeach
                    ]
                }, {
                    name: 'Earn Amount',
                    data: [
                        @foreach ($chart['amount'] as $key => $amount)
                            {{ $amount }},
                        @endforeach
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 580,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        @foreach ($chart['amount'] as $key => $amount)
                            '{{ $key }}',
                        @endforeach
                    ],
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
            chart.render();

            function createCountDown(elementId, sec) {
                var tms = sec;
                var x = setInterval(function() {
                    var distance = tms * 1000;
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes +
                        "m " + seconds + "s ";
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById(elementId).innerHTML = "{{ __('COMPLETE') }}";
                    }
                    tms--;
                }, 1000);
            }
            createCountDown('counter', {{ \Carbon\Carbon::tomorrow()->diffInSeconds() }});
        })(jQuery);
    </script>
@endpush --}}
