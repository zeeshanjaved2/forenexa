@extends($activeTemplate.'layouts.master')
@section('content')
<form action="{{route('user.deposit.insert')}}" method="post">
    @csrf
    <input type="hidden" name="currency" id="currency">
    <div class="row g-4 g-lg-3 g-xxl-4">
        <div class="col-md-7 col-xxl-8">
            <div class="card custom--card">
                <h5 class="card-header">
                    <span class="card-header__icon">
                    <i class="las la-piggy-bank"></i>
                    </span>
                    @lang('Deposit Money')    
                </h5>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">@lang('Select Gateway')</label>
                            <div class="form--select">
                                <select class="form-select" name="gateway" required>
                                    <option value="">@lang('Select One')</option>
                                    @foreach($gatewayCurrency as $data)
                                    <option value="{{$data->method_code}}" @selected(old('gateway') == $data->method_code) data-gateway="{{ $data }}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Amount')</label>
                            <div class="input-group input--group">
                                <input type="number" step="any" name="amount" class="form-control form--control" value="" autocomplete="off" required="" id="amount">
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
                    @lang('Summary')            
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
                                <span class="deposit-card__title fw-bold">@lang('Payable')</span>
                                <span class="deposit-card__amount">
                                <span class="payable">0</span> {{ $general->cur_text }}
                                </span>
                            </li>
                            <li class="d-none rate-element">
                            </li>
                            <li class="d-none in-site-cur">
                                <span class="deposit-card__title">@lang('In') <span class="method_currency"></span></span>
                                <span class="deposit-card__amount">
                                <span class="final_amo">0</span>
                                <span>
                                </span></span>
                            </li>
                            <li class="crypto_currency d-none">
                                <span class="deposit-card__title">@lang('Conversion with') <span class="method_currency"></span> @lang('and final value will Show on next step')</span>
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
<script>
    (function ($) {
        "use strict";
        $('select[name=gateway]').change(function(){
            
            var resource = $('select[name=gateway] option:selected').data('gateway');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            if(resource.method.crypto == 1){
                var toFixedDigit = 8;
                $('.crypto_currency').removeClass('d-none');
            }else{
                var toFixedDigit = 2;
                $('.crypto_currency').addClass('d-none');
            }
            $('.min').text(parseFloat(resource.min_amount).toFixed(2));
            $('.max').text(parseFloat(resource.max_amount).toFixed(2));
            var amount = parseFloat($('input[name=amount]').val());
            if (!amount) {
                amount = 0;
            }
            
            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
            $('.charge').text(charge);
            var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
            $('.payable').text(payable);
            var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge)))*rate).toFixed(toFixedDigit);
            $('.final_amo').text(final_amo);

            if (resource.currency != 'USD') {
                var rateElement = `<span class="deposit-card__title">Conversion Rate</span> <span><span  class="deposit-card__amount">1 USD = <span class="rate">${rate}</span>  <span class="method_currency">${resource.currency}</span></span></span>`;
                $('.rate-element').html(rateElement)
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

            $('.base-currency').text(resource.currency);
            $('.method_currency').text(resource.currency);
            $('input[name=currency]').val(resource.currency);
            $('input[name=amount]').on('input');
        });

        $('input[name=amount]').on('input',function(){
            $('select[name=gateway]').change();
            $('.amount').text(parseFloat($(this).val()).toFixed(2));
        });

    })(jQuery);
</script>
@endpush
