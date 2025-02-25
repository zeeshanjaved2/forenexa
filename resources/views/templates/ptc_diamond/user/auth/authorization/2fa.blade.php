@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="verification-code-wrapper">
            <div class="verification-area">
                <h5 class="pb-3 text-center border-bottom">@lang('2FA Verification')</h5>
                <form action="{{route('user.go2fa.verify')}}" method="POST" class="submit-form">
                    @csrf

                    @include($activeTemplate.'partials.verification_code')

                    <div class="form--group">
                        <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit')</button>
                    </div>
                    <p>
                        @lang('You can') <a href="{{route('user.logout')}}"> @lang('Logout')</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
