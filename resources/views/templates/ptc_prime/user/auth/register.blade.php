@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $registerContent = getContent('register.content', true);
    @endphp

    <section class="account py-120">
        <div class="container">
            <div class="row justify-content-center gy-4">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4 text-center">
                            <h3 class="account-form__title mb-2"> {{ __($registerContent->data_values->heading) }} </h3>
                            <p class="account-form__desc"> {{ __($registerContent->data_values->subheading) }} </p>
                        </div>
                        <form class="verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                @if (session()->get('reference') != null)
                                    <div class="col-sm-12 form-group">
                                        <div class="form--group">
                                            <label class="form--label" for="referenceBy">@lang('Reference by')</label>
                                            <input class="form--control" id="referenceBy" name="referBy" type="text" value="{{ session()->get('reference') }}" readonly>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 form-group">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input class="form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input class="form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="form--group">
                                        <label class="form--label">@lang('Username')</label>
                                        <input class="form--control checkUser" name="username" type="text" value="{{ old('username') }}" required>
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="form--group">
                                        <label class="form--label">@lang('E-Mail Address')</label>
                                        <input class="form--control checkUser" name="email" type="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 form-group">
                                    <div class="form--group">
                                        <label class="form--label">@lang('Country')</label>
                                        <select class="form--control" name="country">
                                            @foreach ($countries as $key => $country)
                                                <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">{{ __($country->country) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="form--group">
                                        <label class="form--label">@lang('Mobile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code">
                                            </span>
                                            <input name="mobile_code" type="hidden">
                                            <input name="country_code" type="hidden">
                                            <input class="form-control form--control checkUser" name="mobile" type="number" value="{{ old('mobile') }}" required>
                                        </div>
                                        <small class="text-danger mobileExist"></small>

                                    </div>
                                </div> --}}
                                <div class="col-sm-12 form-group">
                                    <label class="form--label">@lang('Password')</label>
                                    <div class="position-relative">
                                        <input class="form-control form--control @if ($general->secure_password) secure-password @endif" id="password" name="password" type="password" required>
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <div class="position-relative">
                                        <input class="form-control form--control" id="confirm-password" name="password_confirmation" type="password" required>
                                        <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#confirm-password"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <x-captcha />
                                </div>
                                @if($general->agree)
                                <div class="col-sm-12">
                                    <div class="form--check form-group">
                                        <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                        <div class="form-check-label">
                                            <label for="agree">@lang('I agree with')</label> <span>@foreach($policyPages as $policy) <a href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}" class="text--base" target="_blank">{{ __($policy->data_values->title) }}</a> @if(!$loop->last), @endif @endforeach</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-12 form-group">
                                    <button class="btn btn--base w-100" type="submit"> @lang('Sign Up') </button>
                                </div>
                                @php
                                    $credentials = $general->socialite_credentials;
                                @endphp
                                @if ($credentials->google->status == Status::ENABLE || $credentials->facebook->status == Status::ENABLE || $credentials->linkedin->status == Status::ENABLE)
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="other-option">
                                            <span class="other-option__text">@lang('OR')</span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 form-group flex-wrap">
                                        @if ($credentials->google->status == Status::ENABLE)
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="{{ route('user.social.login', 'google') }}">
                                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/google.png') }}" alt="">
                                                @lang('Google')
                                            </a>
                                        @endif

                                        @if ($credentials->facebook->status == Status::ENABLE)
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="{{ route('user.social.login', 'facebook') }}">
                                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/facebook.png') }}" alt="">
                                                @lang('Facebook')
                                            </a>
                                        @endif

                                        @if ($credentials->linkedin->status == Status::ENABLE)
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="{{ route('user.social.login', 'linkedin') }}">
                                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/linkedin.png') }}" alt="">
                                                @lang('Linkdin')
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Already have an account') <a class="have-account__link underline-with-text" href="{{ route('user.login') }}">@lang('Sign In')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
