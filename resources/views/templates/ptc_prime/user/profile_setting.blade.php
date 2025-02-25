{{-- @extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dashboard-card custom--card">
                <div class="dashboard-card-body">
                    <form class="dashboard-form register" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('First Name')</label>
                                <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}"
                                    required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Last Name')</label>
                                <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('E-mail Address')</label>
                                <input class="form--control" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Mobile Number')</label>
                                <input class="form--control" value="{{ $user->mobile }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Address')</label>
                                <input type="text" class="form--control" name="address"
                                    value="{{ @$user->address->address }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('State')</label>
                                <input type="text" class="form--control" name="state"
                                    value="{{ @$user->address->state }}">
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('Zip Code')</label>
                                <input type="text" class="form--control" name="zip"
                                    value="{{ @$user->address->zip }}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('City')</label>
                                <input type="text" class="form--control" name="city"
                                    value="{{ @$user->address->city }}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('Country')</label>
                                <input class="form--control" value="{{ @$user->address->country }}" disabled>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="form--group">
                                    <label class="form--label">@lang('Country')</label>
                                    <select class="form--control" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                data-code="{{ $key }}" value="{{ $country->country }}">
                                                {{ __($country->country) }}</option>
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
                                        <input class="form-control form--control checkUser" name="mobile" type="number"
                                            value="{{ old('mobile') }}" required>
                                    </div>
                                    <small class="text-danger mobileExist"></small>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
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
</script> --}}
@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dashboard-card custom--card">
                <div class="dashboard-card-body">
                    <form class="dashboard-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('First Name')</label>
                                <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Last Name')</label>
                                <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('E-mail Address')</label>
                                <input class="form--control" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Mobile Number')</label>
                                <input class="form--control" value="{{ $user->mobile }}" name="mobile" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Address')</label>
                                <input type="text" class="form--control" name="address" value="{{ $user->address->address ?? '' }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('State')</label>
                                <input type="text" class="form--control" name="state" value="{{ $user->address->state ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('Zip Code')</label>
                                <input type="text" class="form--control" name="zip" value="{{ $user->address->zip ?? '' }}">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('City')</label>
                                <input type="text" class="form--control" name="city" value="{{ $user->address->city ?? '' }}">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="form--label">@lang('Country')</label>
                                <input class="form--control" value="{{ $user->address->country ?? '' }}" name="country" >
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form--label">@lang('Country')</label>
                                <select class="form--control" name="country">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form--label">@lang('Mobile')</label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code">+{{ $user->address->dial_code ?? '' }}</span>
                                    <input name="mobile_code" type="hidden">
                                    <input name="country_code" type="hidden">
                                    <input class="form-control form--control checkUser" name="mobile" type="number" value="{{ old('mobile', $user->mobile) }}" required>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Update Profile')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    "use strict";
    (function($) {
        $('select[name=country]').change(function() {
            const selected = $(this).find(':selected');
            $('input[name=mobile_code]').val(selected.data('mobile_code'));
            $('input[name=country_code]').val(selected.data('code'));
            $('.mobile-code').text('+' + selected.data('mobile_code'));
        }).trigger('change');

        $('.checkUser').on('focusout', function() {
            const url = '{{ route('user.checkUser') }}';
            const value = $(this).val();
            const token = '{{ csrf_token() }}';
            const data = { mobile: $('.mobile-code').text().substr(1) + value, _token: token };
            $.post(url, data, function(response) {
                if (response.data && response.type) {
                    $(`.${response.type}Exist`).text(`${response.type} already exists`);
                } else {
                    $(`.${response.type}Exist`).text('');
                }
            });
        });
    })(jQuery);
</script>
@endpush
