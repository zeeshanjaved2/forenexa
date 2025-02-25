<?php
    $blogContent  = getContent('blog.content', true);
    $blogElements = getContent('blog.element', false, limit: 3);
?>

<section class="blog py-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="section-heading">
                    <span class="section-heading__subtitle"> <?php echo e(__(@$blogContent->data_values->section_title)); ?> </span>
                    <h2 class="section-heading__title"><?php echo e(__(@$blogContent->data_values->heading)); ?></h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="section-btn text-md-end">
                    <a href="<?php echo e(__(@$blogContent->data_values->button_link)); ?>" class="btn btn--base"> <?php echo e(__(@$blogContent->data_values->button)); ?> </a>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $blogElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="<?php echo e(route('blog.details', [slug(@$blogElement->data_values->title), @$blogElement->id])); ?>" class="blog-item__thumb-link">
                            <img src="<?php echo e(getImage('assets/images/frontend/blog/thumb_' . @$blogElement->data_values->image, '435x300')); ?>" class="fit-image" alt="blog image">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <ul class="text-list flex-align gap-3">
                            <li class="text-list__item fs-16 text--dark"> <span class="text-list__item-icon fs-12 me-1 text--base"></span><i class="far fa-clock"></i>  <?php echo e(showDateTime(@$blogElement->created_at, 'd M Y')); ?> </li>
                        </ul>
                        <h5 class="blog-item__title"><a href="<?php echo e(route('blog.details', [slug(@$blogElement->data_values->title), @$blogElement->id])); ?>" class="blog-item__title-link border-effect">  <?php echo e(__(@$blogElement->data_values->title)); ?>  </a></h5>
                        <p class="blog-item__desc">
                            <?php echo  strLimit(strip_tags(@$blogElement->data_values->description),100) ?>
                        </p>
                        <a href="<?php echo e(route('blog.details', [slug(@$blogElement->data_values->title), @$blogElement->id])); ?>" class="btn--simple border-effect"> <?php echo app('translator')->get('Read More'); ?> <span class="btn--simple__icon"><i class="las la-angle-right"></i></span></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/sections/blog.blade.php ENDPATH**/ ?>