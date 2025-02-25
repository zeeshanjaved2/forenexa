@props(['isCustom' => false])
<div id="confirmationModal" class="modal fade {{ $customModal }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                <button type="button" class="close {{ $closeButton }}" data-bs-dismiss="modal" aria-label="Close">
                    @if(!$closeButton != '')
                        <i class="las la-times"></i>
                    @endif
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn   @if($isCustom) btn-dark btn--sm @else btn-dark @endif" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn @if($isCustom) btn--base btn--sm @else btn--primary  @endif ">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')

<script>
    (function ($) {
        "use strict";
        $(document).on('click','.confirmationBtn', function () {
            var modal   = $('#confirmationModal');
            let data    = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
