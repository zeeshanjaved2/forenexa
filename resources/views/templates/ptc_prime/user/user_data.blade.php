@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="account py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <p class="bg--info p-3 mb-3 text-white">
                        @lang('Complete your profile by providing below data')
                    </p>
                    <div class="account-form">
                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input class="form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input class="form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Address')</label>
                                    <input class="form--control" name="address" type="text" value="{{ old('address') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('State')</label>
                                    <input class="form--control" name="state" type="text" value="{{ old('state') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Zip Code')</label>
                                    <input class="form--control" name="zip" type="text" value="{{ old('zip') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('City')</label>
                                    <input class="form--control" name="city" type="text" value="{{ old('city') }}">
                                </div>
                            </div>
                            <button class="btn btn--base w-100" type="submit">
                                @lang('Submit')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
