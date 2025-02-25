@php
    $planContent = getContent('plan.content', true);
    $plans = App\Models\Plan::where('status', 1)->get();
    $classes = ['text--base', 'text--primary', 'text--base-three', 'text--base-two', 'text--dark', 'text--success'];

    $gatewayCurrency = App\Models\GatewayCurrency::whereHas('method', function ($gate) {
        $gate->where('status', 1);
    })
        ->with('method')
        ->orderby('name')
        ->get();
    $index = 0;
@endphp

<div class="price-plan pt-85 pb-170">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-heading style-center text-center">
                    <span class="section-heading__subtitle"> {{ __(@$planContent->data_values->section_title) }} </span>
                    <h2 class="section-heading__title" s-break="4" s-color="bg--base-two text-white">
                        {{ __(@$planContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($plans as $plan)
                @php
                    $class = @$classes[$index];
                    $index >= 5 ? ($index = 0) : $index++;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="price-item section-bg">
                        @if ($plan->highlight == 1)
                            <span class="price-item__badge">@lang('Most Popular')</span>
                        @endif
                        <div class="price-item__header text-center">
                            <h5 class="price-item__title {{ $class }}">{{ __($plan->name) }}</h5>
                            <p class="price-item__desc">{{ __($plan->tagline) }}</p>
                        </div>
                        <div class="price-item__footer">
                            <ul class="price-item__list">
                                <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Investment') :
                                        {{ getAmount($plan->min_price) }}{{ __($general->cur_sym) }} -
                                        {{ getAmount($plan->max_price) }}{{ __($general->cur_sym) }}</span></li>
                                <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Monthly Profit') :
                                        {{ $plan->monthly_profit }}%</span></li>

                                @if ($general->deposit_commission == 1)
                                    <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Ref Deposit')
                                            : {{ getAmount(depositCommissionLast()) }}%</span></li>
                                @endif

                                @if ($general->ptc_view_commission == 1)
                                    <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Ref Earnings')
                                            : {{ getAmount(earningCommissionLast()) }}%</span></li>
                                @endif

                                @if ($general->plan_subscribe_commission == 1)
                                    <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Plan Upgrade')
                                            : {{ getAmount(planCommissionLast()) }}%</span></li>
                                @endif
                                <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Referral Bonus') :
                                        {{ $plan->ref_level }} @lang('Levels')</span></li>
                                <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Non Working Earning') :
                                        {{ $plan->max_earning }}X</span></li>
                                        <li><i class="far fa-check-circle {{ $class }}"></i> <span>@lang('Working Earning') :
                                            Unlimited</span></li>
                            </ul>
                        </div>
                        <div class="price-item__body">
                            <a class="btn btn--base w-100 buyBtn" data-plan="{{ $plan }}"
                                href="javascript:void(0)">@lang('Get Started')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="modal custom--modal fade" id="BuyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('user.buyPlan') }}">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <strong class="modal-title"> @lang('Confirmation to purchase ')<span class="planName"></span>
                        @lang('Plan')</strong>
                    <button type="button" class="close btn btn--sm btn-close" data-bs-dismiss="modal"></button>
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
                                    <option value="{{ $data->id }}" @selected(old('wallet_type') == $data->method_code)
                                        data-gateway="{{ $data }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <code class="gateway-info rate-info d-none">@lang('Rate'): 1 {{ __($general->cur_text) }}
                                = <span class="rate"></span> <span class="method_currency"></span></code>
                        </div>
                        <div class="form-group">
                            <label>@lang('Invest Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control form--control" name="amount"
                                    required>
                                <span class="input-group-text text-white bg--base">{{ __($general->cur_text) }}</span>
                            </div>
                            <code class="gateway-info d-none">@lang('Charge'): <span class="charge"></span>
                                {{ __($general->cur_text) }}. @lang('Total amount'): <span class="total"></span>
                                {{ __($general->cur_text) }}</code>
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

@push('script')
    <script>
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

                modal.find('.dailyLimit').html(
                    `Daily Ads Limit:<span class="text--danger"> ${plan.daily_limit}</span>`)
                modal.find('.refLevel').html(
                    `Referral Level: <span class="text--danger">${plan.ref_level} </span>`)
                modal.find('.validity').html(
                    `Plan Validity:  <span class="text--danger"> ${plan.validity} Days </span>`)

                $('[name=amount]').on('input', function() {
                    $('[name=wallet_type]').trigger('change');
                })

                $('[name=wallet_type]').change(function() {
                    var amount = $('[name=amount]').val();
                    if ($(this).val() != 'deposit_wallet' && $(this).val() != 'interest_wallet' &&
                        amount) {
                        var resource = $('select[name=wallet_type] option:selected').data('gateway');
                        var fixed_charge = parseFloat(resource.fixed_charge);
                        var percent_charge = parseFloat(resource.percent_charge);
                        var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(
                            2);
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
