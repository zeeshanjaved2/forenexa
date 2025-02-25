@extends($activeTemplate.'layouts.master')
@section('content')
<form action="{{route('user.withdraw.money')}}" method="post">
    @csrf
    <div class="row g-4 g-lg-3 g-xxl-4">
        <div class="col-md-7 col-xxl-8">
            <div class="card custom--card">
                <h5 class="card-header">
                <span class="card-header__icon">
                    <i class="las la-hand-holding-usd"></i>
                </span>
                    @lang('Withdraw Money')
                </h5>
                <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">@lang('Method')</label>
                        <div class="form--select">
                            <select class="form-select" name="method_code" required>
                                <option value="">@lang('Select Gateway')</option>
                                @foreach($withdrawMethod as $data)
                                    <option value="{{ $data->id }}" data-resource="{{$data}}">  {{__($data->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">@lang('Amount')</label>
                        <div class="input-group input--group">
                            <input type="number" step="any" name="amount" value="{{ old('amount') }}" class="form-control form--control" required>
                            <span class="input-group-text">{{ $general->cur_text }}</span>
                        </div>
                        <code class="xsm-text text-muted"><i class="fas fa-info-circle"></i> @lang('Limit') : <span class="min">0</span>  ~ <span class="max">0</span> {{ $general->cur_text }}</code>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-xxl-4">
            <div class="card custom--card">
                <h5 class="card-header">
                <span class="card-header__icon">
                    <i class="las la-file-invoice-dollar"></i>
                </span>
                    @lang('Summery')
                </h5>
                <div class="card-body">
                    <div class="deposit-card">
                        <ul class="deposit-card__list list">
                            <li>
                                <span class="deposit-card__title">@lang('Charge')</span>
                                <span class="deposit-card__amount">
                                <span class="charge">0</span> {{ $general->cur_text }}
                                </span>
                            </li>
                            <li>
                                <span class="deposit-card__title fw-bold">@lang('Receivable')</span>
                                <span class="deposit-card__amount">
                                <span class="receivable">0</span> {{ $general->cur_text }}
                                </span>
                            </li>
                            <li class="d-none rate-element">
                            </li>
                            <li class="d-none in-site-cur">
                                <span class="deposit-card__title">@lang('In') <span class="base-currency"></span></span>
                                <span class="deposit-card__amount">
                                <span class="final_amo">0</span>
                                <span>
                                </span></span>
                            </li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn--lg btn--base w-100 mt-3">@lang('Submit')</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script')
<script type="text/javascript">
    (function ($) {
            "use strict";
            $('select[name=method_code]').change(function(){

                var resource = $('select[name=method_code] option:selected').data('resource');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                var toFixedDigit = 2;
                $('.min').text(parseFloat(resource.min_limit).toFixed(2));
                $('.max').text(parseFloat(resource.max_limit).toFixed(2));
                var amount = parseFloat($('input[name=amount]').val());
                if (!amount) {
                    amount = 0;
                }

                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement = `<span class="deposit-card__title">@lang('Conversion Rate')</span> <span class="deposit-card__amount">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span>`;
                    $('.rate-element').html(rateElement);
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                }else{
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                var receivable = parseFloat((parseFloat(amount) - parseFloat(charge))).toFixed(2);
                $('.receivable').text(receivable);
                var final_amo = parseFloat(parseFloat(receivable)*rate).toFixed(toFixedDigit);
                $('.final_amo').text(final_amo);
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input',function(){
                var data = $('select[name=method_code]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);
</script>
@endpush
