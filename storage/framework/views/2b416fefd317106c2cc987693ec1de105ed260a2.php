<?php
    $testimonialContent  = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element');
    $testimonialElements = $testimonialElements->chunk(round($testimonialElements->count() / 2));
?>


<section class="testimonials pt-170 pb-85">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-heading style-center text-center">
                    <span class="section-heading__subtitle"> <?php echo e(__(@$testimonialContent->data_values->section_title)); ?>

                    </span>
                    <h2 class="section-heading__title" s-break="-2" s-color="bg--base text-white"><?php echo e(__(@$testimonialContent->data_values->heading)); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid g-0">
        <?php $__currentLoopData = $testimonialElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonialElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php if($loop->first): ?> testimonial-slider <?php else: ?> testimonial-slider-rtl <?php endif; ?>"  <?php if(!$loop->first): ?> dir="rtl" <?php endif; ?>>
                <?php $__currentLoopData = $testimonialElement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonialElementLtr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="testimonails-card">
                        <div class="testimonial-item">
                            <div class="testimonial-item__content">
                                <div class="testimonial-item__rating">
                                    <?php
                                        $review = @$testimonialElementLtr->data_values->review;
                                        $noReview = 5 - $review;
                                    ?>
                                    <ul class="rating-list">
                                        <?php for($i = 1; $i <= $review; $i++): ?>
                                            <li class="rating-list__item"><i class="fas fa-star"></i></li>
                                        <?php endfor; ?>

                                        <?php for($i = 1; $i <= $noReview; $i++): ?>
                                            <li class="rating-list__item"><i class="far fa-star"></i></li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                                <p class="testimonial-item__desc">
                                    “<?php echo e(__(@$testimonialElementLtr->data_values->comment)); ?>”</p>
                                <div class="testimonial-item__info">
                                    <div class="testimonial-item__thumb">
                                        <img class="fit-image" src="<?php echo e(getImage('assets/images/frontend/testimonial/' . @$testimonialElementLtr->data_values->image, '60x60')); ?>"
                                            alt="testimonial image">
                                    </div>
                                    <div class="testimonial-item__details">
                                        <h5 class="testimonial-item__name">
                                            <?php echo e(__(@$testimonialElementLtr->data_values->name)); ?> </h5>
                                        <span class="testimonial-item__designation">
                                            <?php echo e(__(@$testimonialElementLtr->data_values->designation)); ?> </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";



            // testimonial slider js
            $(".testimonial-slider").slick({
                dots: false,
                arrows: false,
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                speed: 12000,
                cssEase: "linear",
                autoplay: true,
                autoplaySpeed: 0,
                adaptiveHeight: false,
                autoplay: true,
                pauseOnDotsHover: false,
                pauseOnHover: true,
                pauseOnFocus: true,
                responsive: [{
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ],
            });

            // testimonial slider js
            $(".testimonial-slider-rtl").slick({
                dots: false,
                arrows: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                speed: 12000,
                cssEase: "linear",
                autoplaySpeed: 0,
                autoplay: true,
                pauseOnHover: true,
                pauseOnFocus: true,
                infinite: true,
                rtl: true,
                responsive: [{
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ],
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>


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
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/sections/testimonial.blade.php ENDPATH**/ ?>