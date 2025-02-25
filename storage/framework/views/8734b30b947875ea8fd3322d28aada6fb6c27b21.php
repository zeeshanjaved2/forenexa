<?php
    $counterContent  = getContent('counter.content', true);
    $counterElements = getContent('counter.element', false, limit: 4);
    $classes=['sub text--primary-two','text--base-two','text--green-two','text--orange'];
?>

<div class="counter-area section-bg py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="style-center mb-5 text-center">
                    <h2 class="section-heading__title" s-break-counter="-3"><?php echo e(__(@$counterContent->data_values->heading)); ?></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row justify-content-center gy-4">

                    <?php $__currentLoopData = $counterElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $counterElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="counterup-item">
                                <div class="counterup-item__icon">
                                    <i class="icon-user-1"></i>
                                </div>
                                <div class="counterup-item__content">
                                    <div class="counterup-item__number">
                                        <h2 class="counterup-item__title mb-0">
                                            <span class="odometer" data-odometer-final="<?php echo e(@$counterElement->data_values->number); ?>">0</span>

                                            <sup class="<?php echo e($classes[$key]); ?>"><?php echo e(@$counterElement->data_values->abbreviation); ?></sup>
                                        </h2>
                                    </div>
                                    <p class="counterup-item__text mb-0"> <?php echo e(__(@$counterElement->data_values->title)); ?> </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/odometer.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/odometer.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            // counter up
            $(".counterup-item").each(function() {
                $(this).isInViewport(function(status) {
                    if (status === "entered") {
                        for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
                            var el = document.querySelectorAll('.odometer')[i];
                            el.innerHTML = el.getAttribute("data-odometer-final");
                        }
                    }
                });
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/sections/counter.blade.php ENDPATH**/ ?>