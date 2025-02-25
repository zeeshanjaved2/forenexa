@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $content = getContent('register.content',true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp
<div class="section login-section">
	<div class="container">
		<div class="row g-4 justify-content-between align-items-center">
			<div class="col-lg-6">
				<img src="{{ getImage('assets/images/frontend/register/'.$content->data_values->image, '1382x1445') }}" alt="images" class="img-fluid" />
			</div>
			<div class="col-lg-6 col-xxl-5">
				<div class="login-form">
					<h3 class="login-form__title">{{ __($content->data_values->heading) }}</h3>
					<form action="{{ route('user.register') }}" class="row g-3 g-xxl-4 verify-gcaptcha" method="post">
                        @csrf
						@if (session()->get('reference') != null)
                            <div class="col-12">
                                <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                <input type="text" name="referBy" id="referenceBy" class="form-control form--control" value="{{ session()->get('reference') }}" readonly>
                            </div>
                        @endif

                        <div class="col-md-6">
							<label for="username" class="form-label">@lang('Username')</label>
                            <input type="text" name="username" id="username" placeholder="@lang('Username')" class="form-control form--control checkUser" value="{{ old('username') }}" required>
                            <small class="text-danger usernameExist"></small>
						</div>

						<div class="col-md-6">
							<label for="email" class="form-label">@lang('Email')</label>
                            <input type="email" name="email" id="email" placeholder="@lang('Email')" class="form-control form--control checkUser" value="{{ old('email') }}" required>
						</div>

                        <div class="col-md-6">
                            <label class="form-label" for="country">@lang('Country')</label>
                            <div class="form--select">
                                <select id="country" name="country" class="form-select" required>
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
							<label class="form-label" for="mobile">@lang('Mobile')</label>
							<div class="input-group input--group">
                                <span class="input-group-text mobile-code"></span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                            </div>
                            <small class="text-danger mobileExist"></small>
						</div>

						<div class="col-md-6 form-group mb-0">
							<label class="form-label" for="password">@lang('Password')</label>
							<input type="password" id="password" name="password" class="form-control form--control @if ($general->secure_password) secure-password @endif" placeholder="@lang('Password')" required>
                           
						</div>

						<div class="col-md-6">
							<label class="form-label" for="password_confirmation">@lang('Re-type Password')</label>
							<input type="password" id="password_confirmation" name="password_confirmation" class="form-control form--control" placeholder="@lang('Re-type Password')" required>
						</div>

                        <x-captcha />

                        @if ($general->agree)
                            <div class="col-12">
                                <div class="form-check form--check d-block">
                                    <input type="checkbox" id="agree" @checked(old('agree')) name="agree" class="form-check-input custom--check" required>
                                    <label class="form-check-label form-label" for="agree">@lang('I agree with ') </label> <span>@foreach ($policyPages as $policy)
                                        <a class="t-link t-link--base text--base" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach</span>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <button type="submit" class="btn btn--lg btn--base w-100 rounded">@lang('Register Now')</button>
                        </div>
					</form>
					
					 @php
                            $credentials = $general->socialite_credentials;
                        @endphp
                        @if ($credentials->google->status == 1 || $credentials->facebook->status == 1 || $credentials->linkedin->status == 1)
                            <div class="col-12 my-3">
                                <p class="text-center sm-text mb-2">@lang('Or Login with')</p>

                                <div class="socials-buttons d-flex flex-wrap flex-row gap-10 justify-content-between">

                                    @if ($credentials->google->status == 1)
                                        <a href="{{ route('user.social.login', 'google') }}" class="btn btn-outline-google btn-sm text-uppercase">
                                            <span class="me-1"><i class="fab fa-google"></i></span> @lang('Google')</a>
                                    @endif

                                    @if ($credentials->facebook->status == 1)
                                        <a href="{{ route('user.social.login', 'facebook') }}" class="btn btn-outline-facebook btn-sm text-uppercase">
                                            <span class="me-1"><i class="fab fa-facebook-f"></i></span> @lang('Facebook')</a>
                                    @endif

                                    @if ($credentials->linkedin->status == 1)
                                        <a href="{{ route('user.social.login', 'linkedin') }}" class="btn btn-outline-linkedin btn-sm text-uppercase">
                                            <span class="me-1"><i class="fab fa-linkedin-in"></i></span> @lang('Linkedin')</a>
                                    @endif
                                </div>
                            </div>
                        @endif
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <h6 class="text-center">@lang('You already have an account please Login ')</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
            .btn {
            border: 1px solid transparent !important;
        }

        .content-area {
            z-index: -1;
            height: 100%;
        }

        .btn-outline-linkedin {
            border-color: #0077B5 !important;
            background-color: #0077B5;
            color: #ffff;
        }

        .btn-outline-linkedin:hover {
            border-color: #0077B5 !important;
            color: #fff !important;
            background-color: #0077B5;
        }

        .btn-outline-facebook {
            border-color: #395498 !important;
            background-color: #395498;
            color: #ffff;
        }

        .btn-outline-facebook:hover {
            border-color: #395498 !important;
            color: #fff !important;
            background-color: #395498;
        }

        .btn-outline-google {
            border-color: #D64937 !important;
            background-color: #D64937;
            color: #ffff;
        }

        .btn-outline-google:hover {
            border-color: #D64937;
            color: #fff !important;
            background-color: #D64937;
        }

        .row>* {
            padding-right: calc(var(--bs-gutter-x) * .0);
        }

        .socials-buttons .btn {
            width: calc(33% - 10px);
        }

        @media (max-width: 424px) {
            .socials-buttons .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
@endpush

@if($general->secure_password)
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
