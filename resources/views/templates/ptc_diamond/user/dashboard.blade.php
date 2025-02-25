@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $kycInfo = getContent('kyc_info.content',true);
@endphp
<div class="row g-4 g-lg-3 g-xxl-4">
    @if(auth()->user()->kv == 0)
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <h5 class="alert-heading mt-0">@lang('KYC Verification required')</h5>
                <hr>
                <p class="mb-0">{{ __($kycInfo->data_values->verification_content) }} <a
                        href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
                </p>
            </div>
        </div>
    @elseif(auth()->user()->kv == 2)
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <h5 class="alert-heading mt-0">@lang('KYC Verification pending')</h5>
                <hr>
                <p class="mb-0">{{ __($kycInfo->data_values->pending_content) }} <a
                        href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
            </div>
        </div>
    @endif

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Total Deposit')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ showAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Total Withdraw')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ showAmount($user->withdrawals->where('status',1)->sum('amount')) }} {{ $general->cur_text }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-credit-card"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('My Plan')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        @if($user->plan)
                        {{ __($user->plan->name) }} @if($user->expire_date < now()) (@lang('Expired')) @endif
                    @else
                        @lang('No Plan')
                    @endif
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-list"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Total Clicks')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ $user->clicks->count() }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-trophy"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang("Today's Clicks")
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-link"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ $user->clicks->where('view_date',Date('Y-m-d'))->count() }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-link"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Remain clicks for today')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-link"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ $user->daily_limit - $user->clicks->where('view_date',Date('Y-m-d'))->count() }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-link"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Next Reminder')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount timer" id="counter">
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('Referral Commissions')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ __($commissionCount) }} {{ $general->cur_text }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-xl-4">
        <div class="widget-container">
            <div class="widget-container__head">
                <span class="dashboard-widget__title">
                    @lang('My Active ADS')
                </span>
            </div>
            <div class="dashboard-widget">
                <div class="dashboard-widget__icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="dashboard-widget__content">
                    <h4 class="dashboard-widget__amount">
                        {{ __($activeAdCount) }}
                    </h4>
                </div>
                <span class="dashboard-widget__overlay-icon">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-30">
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">@lang('Click & Earn Report')</h5>
                <div id="apex-bar-chart"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
<script>
(function ($) {
    "use strict";
    // apex-bar-chart js
    var options = {
      series: [{
      name: 'Clicks',
      data: [
        @foreach($chart['click'] as $key => $click)
            {{ $click }},
        @endforeach
      ]
    }, {
      name: 'Earn Amount',
      data: [
            @foreach($chart['amount'] as $key => $amount)
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
      @foreach($chart['amount'] as $key => $amount)
                '{{ $key }}',
            @endforeach
    ],
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
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
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }
      createCountDown('counter', {{\Carbon\Carbon::tomorrow()->diffInSeconds()}});
})(jQuery);
</script>
@endpush
