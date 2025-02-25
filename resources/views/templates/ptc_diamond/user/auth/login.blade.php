@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('login.content', true);
    @endphp
    <div class="section login-section">
        <div class="container">
            <div class="row g-4 justify-content-between align-items-center">
                <div class="col-lg-6">
                    <img src="{{ getImage('assets/images/frontend/login/' . $content->data_values->image, '1382x1445') }}" alt="images" class="img-fluid" />
                </div>
                <div class="col-lg-6 col-xxl-5">
                    <div class="login-form">
                        <h3 class="login-form__title">{{ __($content->data_values->heading) }}</h3>
                        <form action="{{ route('user.login') }}" class="row g-3 g-xxl-4 verify-gcaptcha" method="post">
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="username">@lang('Username or Email')</label>
                                <input type="username" id="username" name="username" class="form-control form--control" placeholder="@lang('Username or Email')" required />
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="password">@lang('Password')</label>
                                <input type="password" id="password" name="password" class="form-control form--control" placeholder="@lang('Password')" required />
                            </div>

                            <x-captcha />

                            <div class="col-sm-6">
                                <div class="form-check form--check">
                                    <input class="form-check-input custom--check" type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label form-label" for="rememberMe">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{ route('user.password.request') }}" class="t-link d-block text-sm-end text--base t-link--base form-label lh-1">
                                    @lang('Forgot password?')
                                </a>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn--lg btn--base w-100 rounded">@lang('Login Now')</button>
                            </div>

                            <div class="col-12">
                                <p class="m-0 sm-text text-center lh-1">
                                    @lang('Don`t have an account?')' <a href="{{ route('user.register') }}" class="t-link t-link--base text--base">@lang('Create an Account')</a>
                                </p>
                            </div>
                        </form>

                        @php
                            $credentials = $general->socialite_credentials;
                        @endphp
                        @if ($credentials->google->status == Status::ENABLE || $credentials->facebook->status == Status::ENABLE || $credentials->linkedin->status == Status::ENABLE)
                            <div class="col-12 my-3">
                                <p class="text-center sm-text mb-2">@lang('Or Login with')</p>

                                <div class="socials-buttons d-flex flex-wrap flex-row gap-10 justify-content-between">

                                    @if ($credentials->google->status == Status::ENABLE)
                                        <a href="{{ route('user.social.login', 'google') }}" class="btn btn-outline-google btn-sm text-uppercase">
                                            <span class="me-1"><i class="fab fa-google"></i></span> @lang('Google')</a>
                                    @endif

                                    @if ($credentials->facebook->status == Status::ENABLE)
                                        <a href="{{ route('user.social.login', 'facebook') }}" class="btn btn-outline-facebook btn-sm text-uppercase">
                                            <span class="me-1"><i class="fab fa-facebook-f"></i></span> @lang('Facebook')</a>
                                    @endif

                                    @if ($credentials->linkedin->status == Status::ENABLE)
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
@endsection
@push('style')
    <style>
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
