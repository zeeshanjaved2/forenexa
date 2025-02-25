<?php
    $featureContent  = getContent('features.content', true);
    $featureElements = getContent('features.element', orderById: true,limit:8);
?>

<section class="features pt-85 pb-85">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="">
                    <h1 class="feature_heading__subtitle"> <?php echo e(__(@$featureContent->data_values->section_title)); ?> </h1>
                    
                </div>
            </div>
            
        </div>

        <div class="row gy-4">
            <?php $__currentLoopData = $featureElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="features-item section-bg">
                    <div class="features-item__icon">
                        <img src="<?php echo e(getImage('assets/images/frontend/features/' . @$featureElement->data_values->icon_image, '60x60')); ?>">
                    </div>
                    <h5 class="features-item__title"> <?php echo e(__(@$featureElement->data_values->title)); ?> </h5>
                    <p class="features-item__desc"> <?php echo e(__(@$featureElement->data_values->content)); ?> </p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</section>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/sections/features.blade.php ENDPATH**/ ?>