@extends('admin.layouts.app')

@section('panel')
    <div class="col-lg-12">
        <div class="card border--primary">
            <div class="card-header bg--primary text-white">
                <h5 class="mb-0">@lang('Update Settings')</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.notification.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="Status">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="notification_modal" {{ $general->notification_modal ? 'checked' : '' }}>
                    </div>
                    <div class="form-group">
                        <label for="modal_text" class="form-label">@lang('Notification Text')</label>
                        <textarea id="modal_text" rows="5" class="form-control border-radius-5 nicEdit" name="modal_text">{{ old('modal_text', $general->modal_text) }}</textarea>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn--primary">@lang('Save Changes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
