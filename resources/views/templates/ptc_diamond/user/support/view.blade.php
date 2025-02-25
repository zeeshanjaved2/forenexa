@extends($activeTemplate . 'layouts.' . $layout)
@section('content')

@if ($layout == 'frontend')
    <div class="container">
@endif

<div class="card custom--card support-ticket">
    <h5 class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
        <span class="mt-0">
            @php echo $myTicket->statusBadge; @endphp
            [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
        </span>
        @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
            <span class="confirmationBtn text-danger c-pointer" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}"><i class="las la-lg la-times-circle"></i>
            </span>
        @endif
        </h5>
    <div class="card-body">
        <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-between">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="message" class="form-control form--control" rows="4">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <a href="javascript:void(0)" class="btn btn--base btn-sm addFile"><i class="fa fa-plus"></i> @lang('Add New')</a>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('Attachments')</label> <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                <input type="file" name="attachments[]" class="form-control form--control"/>
                <div id="fileUploadsContainer"></div>
                <code class="xsm-text text-muted">
                    <i class="fas fa-info-circle"></i> @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                </code>
            </div>
            <button type="submit" class="btn btn--base btn--lg w-100"> <i class="fa fa-reply"></i> @lang('Reply')</button>
        </form>
    </div>
    <div class="card-footer">
        <ul class="list support-list">
        @foreach ($messages as $message)
            @if ($message->admin_id == 0)
                <li>
                    <div class="support-card">
                        <div class="support-card__head">
                            <h5 class="support-card__title">{{ $message->ticket->name }}</h5>
                            <span class="support-card__date">
                                <code class="xsm-text text-muted">
                                    <i class="far fa-calendar-alt"></i> @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                </code>
                            </span>
                        </div>
                        <div class="support-card__body">
                            <p class="support-card__body-text text-center text-md-start mb-0">{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <ul class="list list--row flex-wrap support-card__list justify-content-center justify-content-md-start">
                                    @foreach ($message->attachments as $k => $image)
                                        <li>
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3 support-card__file">
                                                <span class="support-card__file-icon"><i class="fa fa-file"></i></span>
                                                <span class="support-card__file-text">@lang('Attachment') {{ ++$k }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                            @endif
                        </div>
                    </div>
                </li>
            @else
                <li>
                    <div class="support-card" style="background-color: #ffd96729">
                        <div class="support-card__head">
                            <h5 class="support-card__title">{{ $message->admin->name }}</h5>
                            <span class="support-card__date">
                                <code class="xsm-text text-muted">
                                    <i class="far fa-calendar-alt"></i> @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                </code>
                            </span>
                        </div>
                        <div class="support-card__body">
                            <p class="support-card__body-text text-center text-md-start mb-0">{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <ul class="list list--row flex-wrap support-card__list justify-content-center justify-content-md-start">
                                    @foreach ($message->attachments as $k => $image)
                                    <li>
                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3 support-card__file">
                                            <span class="support-card__file-icon"><i class="fa fa-file"></i></span>
                                            <span class="support-card__file-text">@lang('Attachment') {{ ++$k }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
        </ul>
    </div>
</div>

@if ($layout == 'frontend')
    </div>
@endif

<x-confirmation-modal customModal="custom--modal" closeButton="btn-close" />

@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button type="submit" class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
