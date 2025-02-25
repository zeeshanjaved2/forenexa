@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-table__header d-flex justify-content-end pt-0 px-0">
        <div class="dashboard-table__btn">
            <form class="dashboard-form" action="">
                <div class="input-group">
                    <input class="form--control form-control" name="search" type="text" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                    <button class="input-group-text bg--base text-white">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card custom--card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table--responsive--lg table">
                    <thead>
                        <tr>
                            <th>@lang('Gateway | Transaction')</th>
                            <th class="text-center">@lang('Initiated')</th>
                            <th class="text-center">@lang('Amount')</th>
                            <th class="text-center">@lang('Conversion')</th>
                            <th class="text-center">@lang('Status')</th>
                            <th>@lang('Details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold"> <span class="text-primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                        <br>
                                        <small> {{ $deposit->trx }} </small>
                                    </div>
                                </td>

                                <td class="text-end text-md-center">
                                    <div>
                                        <span class="d-block">{{ showDateTime($deposit->created_at) }} </span>
                                        <span>{{ diffForHumans($deposit->created_at) }}</span>

                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    <div>
                                        {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span class="text-danger" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                        <br>
                                        <strong title="@lang('Amount with charge')">
                                            {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                        </strong>
                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    <div>
                                        1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }} {{ __($deposit->method_currency) }}
                                        <br>
                                        <strong>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</strong>
                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    @php echo $deposit->statusBadge @endphp
                                </td>
                                @php
                                    $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                @endphp

                                <td>
                                    <a class="btn btn-outline--base btn--sm @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif" href="javascript:void(0)" @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                        <i class="las la-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($deposits->hasPages())
    {{ $deposits->links() }}
   @endif
    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
