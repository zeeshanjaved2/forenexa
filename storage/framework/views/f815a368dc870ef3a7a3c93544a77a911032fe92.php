<?php
    $footerContent  = getContent('footer.content', true);
    $socialIcons    = getContent('social_icon.element', false, false, true);
    $footerElements = getContent('footer.element');
    $policyPages    = getContent('policy_pages.element', false, null, true);
?>


<footer class="footer-area">
    <div class="pb-60 pt-60">
        <div class="container">
            <div class="footer-item__logo">
                <a href="<?php echo e(route('home')); ?>"> <img src="<?php echo e(siteLogo()); ?>" alt=""></a>
            </div>
            <div class="row justify-content-center gy-5">
                <div class="col-xl-6 col-sm-6 col-xsm-6">
                    <div class="footer-item footer-item-left">
                        <p class="footer-item__desc"> <?php echo e(__(@$footerContent->data_values->about)); ?> </p>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Quick Link'); ?></h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item"><a class="footer-menu__link" href="<?php echo e(route('plans')); ?>"><?php echo app('translator')->get('Plans'); ?></a></li>
                            <li class="footer-menu__item"><a class="footer-menu__link" href="<?php echo e(route('blog')); ?>"><?php echo app('translator')->get('Blogs'); ?></a></li>
                            <li class="footer-menu__item"><a class="footer-menu__link" href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Privacy and Terms'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-menu__item"><a class="footer-menu__link" href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>">
                                     <?php echo e(__($policy->data_values->title)); ?> </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"> <?php echo app('translator')->get('Contact Info'); ?> </h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $footerElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footerElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-menu__item">
                                    <div class="d-flex footer-icon">
                                        <?php
                                            $type=@$footerElement->data_values->information_type;
                                             echo $footerElement->data_values->icon
                                        ?>
                                       <?php if($type=='mailto' ||$type=='tel'  ): ?>
                                         <a class="footer-menu__link" href="<?php echo e($type); ?>:<?php echo e($footerElement->data_values->information); ?>">
                                            <?php echo e($footerElement->data_values->information); ?>

                                         </a>
                                       <?php else: ?>
                                          <span> <?php echo e(__($footerElement->data_values->information)); ?> </span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="row gy-3 align-items-center">
                    <div class="col-md-8">
                        <div class="bottom-footer-copyright">
                            <ul>
                                <li><?php echo app('translator')->get('Copyright'); ?> &copy; <?php echo e(date('Y')); ?>. <?php echo app('translator')->get('All Rights Reserved By'); ?> <a class="t-link" href="<?php echo e(route('home')); ?>"><?php echo e(__($general->site_name)); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-social">
                            <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($social->data_values->url); ?>" target="_blank">
                                    <?php echo $social->data_values->icon; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</footer>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/partials/footer.blade.php ENDPATH**/ ?>