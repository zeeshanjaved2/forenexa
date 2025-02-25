<?php
	$customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha()
?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['isCustom' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['isCustom' => false]); ?>
<?php foreach (array_filter((['isCustom' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php if($googleCaptcha): ?>
    <div class="mb-3">
        <?php echo $googleCaptcha ?>
    </div>
<?php endif; ?>
<?php if($customCaptcha): ?>
    <div class="form-group">
        <div class="mb-2">
            <?php echo $customCaptcha ?>
        </div>
        <label class="<?php if($isCustom): ?> form--label <?php else: ?> form-label <?php endif; ?>"><?php echo app('translator')->get('Captcha'); ?></label>
        <input type="text" name="captcha" class="form-control form--control" required>
    </div>
<?php endif; ?>
<?php if($googleCaptcha): ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($){
            "use strict"
            $('.verify-gcaptcha').on('submit',function(){
                var response = grecaptcha.getResponse();
                if (response.length == 0) {
                    document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger"><?php echo app('translator')->get("Captcha field is required."); ?></span>';
                    return false;
                }
                return true;
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/partials/captcha.blade.php ENDPATH**/ ?>