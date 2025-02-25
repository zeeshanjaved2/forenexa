<?php
    $brandElements = getContent('brand.element');
?>

<div class="client section-bg py-60">
    <div class="container">
        <div class="client-logos client-slider">
            <?php $__currentLoopData = $brandElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(getImage('assets/images/frontend/brand/' . @$brandElement->data_values->image, '140x40')); ?>" alt="brand image">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<?php if(!app()->offsetExists('slick_style')): ?>
    <?php $__env->startPush('style-lib'); ?>
        <link href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <?php app()->offsetSet('slick_style',true) ?>
<?php endif; ?>

<?php if(!app()->offsetExists('slick_script')): ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
    <?php app()->offsetSet('slick_script',true) ?>
<?php endif; ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.client-slider').slick({
                slidesToShow: 7,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1000,
                pauseOnHover: true,
                speed: 2000,
                dots: false,
                arrows: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 6,
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 5
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 3
                        }
                    }
                ]
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/sections/brand.blade.php ENDPATH**/ ?>