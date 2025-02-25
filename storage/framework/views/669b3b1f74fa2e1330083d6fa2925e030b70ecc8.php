<?php
    $languages       = App\Models\Language::get();
    $defaultLanguage = App\Models\Language::where('code', config('app.locale'))->first();
    $pages           = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
?>

<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-light">
            <a class="navbar-brand logo" href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset(siteLogo())); ?>" alt="logo"></a>
            <button class="navbar-toggler header-button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu align-items-xl-center ms-auto">
                    <li class="nav-item d-block d-xl-none">
                        <div class="top-button d-flex justify-content-between align-items-center flex-wrap">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected dropdown-list__item">
                                    <div class="thumb"> <img src="<?php echo e(getImage(getFilePath('flag') . '/' . $defaultLanguage->flag, getFileSize('flag'))); ?>" alt="image"></div>
                                    <span class="text text-capitalize"> <?php echo e($defaultLanguage->code); ?> </span>
                                </div>
                                <ul class="dropdown-list">
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dropdown-list__item langSel" data-value="<?php echo e($language->code); ?>">
                                            <a class="thumb" href="#"> <img src="<?php echo e(getImage(getFilePath('flag') . '/' . $language->flag), getFileSize('flag')); ?>" alt="image"></a>
                                            <span class="text text-capitalize"> <?php echo e($language->code); ?> </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <ul>
                                <?php if(auth()->guard()->check()): ?>
                                <li class="header-login__item">
                                    <a class="btn btn--base" href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                                </li>
                                <?php else: ?>
                                <li class="header-login__item">
                                    <a class="btn btn--base" href="<?php echo e(route('user.register')); ?>"><?php echo app('translator')->get('Get Started'); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('home')); ?>">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>" aria-current="page"><?php echo app('translator')->get('Home'); ?></a>
                    </li>
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item <?php echo e(menuActive('pages', [$page->slug])); ?>">
                            <a class="nav-link" href="<?php echo e(route('pages', [$page->slug])); ?>" aria-current="page"> <?php echo e(__($page->name)); ?> </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item <?php echo e(menuActive('plans')); ?>">
                        <a class="nav-link" href="<?php echo e(route('plans')); ?>"><?php echo app('translator')->get('Plans'); ?></a>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('blog')); ?>">
                        <a class="nav-link" href="<?php echo e(route('blog')); ?>"> <?php echo app('translator')->get('Blogs'); ?> </a>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('contact')); ?>">
                        <a class="nav-link" href="<?php echo e(route('contact')); ?>"> <?php echo app('translator')->get('Contact'); ?> </a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('user.logout')); ?>"><?php echo app('translator')->get('Logout'); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?php echo e(menuActive('user.login')); ?>">
                            <a class="nav-link" href="<?php echo e(route('user.login')); ?>"><?php echo app('translator')->get('Login'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-none d-xl-block">
                    <ul class="header-login list primary-menu">
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="header-login__item">
                                <a class="btn btn--base" href="<?php echo e(route('user.register')); ?>"><?php echo app('translator')->get('Get Started'); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if(auth()->guard()->check()): ?>
                            <li class="header-login__item">
                                <a class="btn btn--base" href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                        <?php endif; ?>

                        <li class="header-login__item">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected dropdown-list__item">
                                    <div class="thumb"> <img src="<?php echo e(getImage(getFilePath('flag') . '/' . $defaultLanguage->flag, getFileSize('flag'))); ?>" alt="image"></div>
                                    <span class="text text-capitalize"> <?php echo e($defaultLanguage->code); ?> </span>
                                </div>
                                <ul class="dropdown-list">
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dropdown-list__item langSel" data-value="<?php echo e($language->code); ?>">
                                            <a class="thumb" href="#">
                                                 <img src="<?php echo e(getImage(getFilePath('flag') . '/' . $language->flag), getFileSize('flag')); ?>" alt="image">
                                            </a>
                                            <span class="text text-capitalize"> <?php echo e($language->code); ?> </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>
<?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/partials/header.blade.php ENDPATH**/ ?>