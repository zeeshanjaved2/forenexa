@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section--sm pricing-section">
        <div class="container-xl">
            <div class="row g-3 justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-sm-6 col-lg-3">
                        <div class="pricing {{ $plan->highlight == 1 ? 'pricing--popular' : '' }}">
                            @if ($plan->highlight == 1)
                                <span class="pricing__tag">@lang('Popular')</span>
                            @endif
                            <div class="pricing__head">
                                <h4 class="pricing__title">{{ __($plan->name) }}</h4>
                                <span class="pricing__sub-title">
                                    {{ __($plan->tagline) }}
                                </span>
                            </div>
                            <div class="pricing__plan">
                                <div class="pricing__plan-container">
                                    <div class="pricing__price">
                                        <span class="pricing__currency">
                                            <i class="las la-dollar-sign"></i>
                                        </span>
                                        <h1 class="pricing__amount">
                                            {{ __(showAmount($plan->price)) }}
                                        </h1>
                                    </div>
                                    <span class="pricing__text">{{ $general->cur_text }}</span>
                                </div>


                                @if (@auth()->user()->runningPlan && @auth()->user()->plan_id == $plan->id)
                                    <button class="pricing__btn disabled">@lang('Current Package')</button>
                                @else
                                    <button class="pricing__btn {{ $plan->highlight == 1 ? 'pricing__btn-popular' : 'pricing__btn-regular' }} buyBtn" data-plan="{{ $plan }}">
                                        @lang('Subscribe Now')
                                    </button>
                                @endif

                            </div>
                            <div class="pricing__body">
                                <ul class="list pricing__list">
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Daily Limit') : {{ $plan->daily_limit }} @lang('PTC')
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Referral Bonus') : @lang('Upto') {{ $plan->ref_level }} @lang('Level')
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Plan Price') : {{ showAmount($plan->price) }} {{ __($general->cur_text) }}
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Validity') : {{ $plan->validity }} @lang('Days')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="modal custom--modal fade" id="BuyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" action="{{ route('user.buyPlan') }}">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="modal-header">
                            <strong class="modal-title"> @lang('Confirmation to purches  ')<span class="planName"></span></strong>

                            <button type="button" class="close btn btn-sm btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            @auth
                                <div class="form-group">
                                    @if (auth()->user()->runningPlan)
                                        <code class="d-block">@lang('If you subscribe to this one. Your old limitation will reset according to this package.')</code>
                                    @endif

                                    <h6 class="text-center dailyLimit"></h6>
                                    <p class="text-center refLevel"></p>
                                    <p class="text-center mt-1 validity"></p>

                                    <label>@lang('Select Wallet')</label>
                                    <select class="form--control  form-select" name="wallet_type" required>
                                        <option value="">@lang('Select One')</option>
                                        @if (auth()->user()->balance > 0)
                                            <option value="deposit_wallet">@lang('Deposit Wallet - ' . $general->cur_sym . showAmount(auth()->user()->balance))</option>
                                        @endif

                                        @foreach ($gatewayCurrency as $data)
                                            <option value="{{ $data->id }}" @selected(old('wallet_type') == $data->method_code) data-gateway="{{ $data }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    <code class="gateway-info rate-info d-none">@lang('Rate'): 1 {{ $general->cur_text }}
                                        = <span class="rate"></span> <span class="method_currency"></span></code>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Invest Amount')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control form--control" name="amount" required>
                                        <span class="input-group-text text--white bg--base">{{ $general->cur_text }}</span>
                                    </div>
                                    <code class="gateway-info d-none">@lang('Charge'): <span class="charge"></span>
                                        {{ $general->cur_text }}. @lang('Total amount'): <span class="total"></span>
                                        {{ $general->cur_text }}</code>
                                </div>
                            @else
                                <p>@lang('Please login to subscribe plan')</p>
                            @endauth
                        </div>
                        <div class="modal-footer">
                            @auth
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                                <button type="submit" class="btn btn--base">@lang('Yes')</button>
                            @else
                                <a href="{{ route('user.login') }}" class="btn btn--base w-100">@lang('Login')</a>
                            @endauth
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
@push('style')
    <style>
        .package-disabled {
            opacity: 0.5;
        }
    </style>
@endpush
@push('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
            $('.buyBtn').click(function() {
                let symbol = '{{ $general->cur_sym }}';
                let currency = '{{ $general->cur_text }}';
                $('.gateway-info').addClass('d-none');
                let modal = $('#BuyModal');
                let plan = $(this).data('plan')
                modal.find('.planName').text(plan.name)
                modal.find('[name=id]').val(plan.id)
                let planPrice = parseFloat(plan.price).toFixed(2);
                modal.find('[name=amount]').val(planPrice);
                modal.find('[name=amount]').attr('readonly', true);

                modal.find('.dailyLimit').html(`Daily Ads Limit:<span class="text--danger"> ${plan.daily_limit}</span>`)
                modal.find('.refLevel').html(`Referral Level: <span class="text--danger">${plan.ref_level} </span>`)
                modal.find('.validity').html(`Plan Validity:  <span class="text--danger"> ${plan.validity} Days </span>`)

                $('[name=amount]').on('input', function() {
                    $('[name=wallet_type]').trigger('change');
                })

                $('[name=wallet_type]').change(function() {
                    var amount = $('[name=amount]').val();
                    if ($(this).val() != 'deposit_wallet' && $(this).val() != 'interest_wallet' && amount) {
                        var resource = $('select[name=wallet_type] option:selected').data('gateway');
                        var fixed_charge = parseFloat(resource.fixed_charge);
                        var percent_charge = parseFloat(resource.percent_charge);
                        var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                        $('.charge').text(charge);
                        $('.rate').text(parseFloat(resource.rate));
                        $('.gateway-info').removeClass('d-none');
                        if (resource.currency == '{{ $general->cur_text }}') {
                            $('.rate-info').addClass('d-none');
                        } else {
                            $('.rate-info').removeClass('d-none');
                        }
                        $('.method_currency').text(resource.currency);
                        $('.total').text(parseFloat(charge) + parseFloat(amount));
                    } else {
                        $('.gateway-info').addClass('d-none');
                    }
                });
                modal.find('input[name=id]').val(plan.id);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
