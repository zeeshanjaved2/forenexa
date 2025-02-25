<?php $__env->startSection('content'); ?>
    <?php
        $loginContent = getContent('login.content', true);
    ?>
    <div class="container">
        <section class="account py-120">
            <div class="container">
                <div class="row justify-content-center gy-4">
                    <div class="col-lg-6">
                        <div class="account-form">
                            <div class="account-form__content mb-4 text-center">
                                <h3 class="account-form__title mb-2"> <?php echo e(__($loginContent->data_values->heading)); ?> </h3>
                                <p class="account-form__desc"> <?php echo e(__($loginContent->data_values->subheading)); ?> </p>
                            </div>
                            <form class="verify-gcaptcha" method="POST" action="<?php echo e(route('user.login')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="form--label" for="email"><?php echo app('translator')->get('Username or Email'); ?></label>
                                        <input class="form--control" name="username" type="text" value="<?php echo e(old('username')); ?>" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                        <div class="position-relative">
                                            <input class="form--control" id="password" name="password" type="password" required>
                                            <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243)): ?>
<?php $component = $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243; ?>
<?php unset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243); ?>
<?php endif; ?>
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="btn btn--base w-100" type="submit"><?php echo app('translator')->get('Sign In'); ?></button>
                                    </div>

                                    <?php
                                    $credentials = $general->socialite_credentials;
                                ?>
                                <?php if($credentials->google->status == Status::ENABLE || $credentials->facebook->status == Status::ENABLE || $credentials->linkedin->status == Status::ENABLE): ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="other-option">
                                            <span class="other-option__text"><?php echo app('translator')->get('OR'); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 form-group flex-wrap">
                                        <?php if($credentials->google->status == Status::ENABLE): ?>
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="<?php echo e(route('user.social.login', 'google')); ?>">
                                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/thumbs/google.png')); ?>" alt="">
                                                <span><?php echo app('translator')->get('Google'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($credentials->facebook->status == Status::ENABLE): ?>
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="<?php echo e(route('user.social.login', 'facebook')); ?>">
                                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/thumbs/facebook.png')); ?>" alt="">
                                               <span> <?php echo app('translator')->get('Facebook'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($credentials->linkedin->status == Status::ENABLE): ?>
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="<?php echo e(route('user.social.login', 'linkedin')); ?>">
                                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/thumbs/linkedin.png')); ?>" alt="">
                                                <span> <?php echo app('translator')->get('Linkdin'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                    <div class="col-sm-12 pb-2">
                                        <div class="have-account text-center">
                                            <p class="have-account__text"> <a class="have-account__link underline-with-text" href="<?php echo e(route('user.password.request')); ?>"><?php echo app('translator')->get('Forgot your password?'); ?></a></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="have-account text-center">
                                            <p class="have-account__text"> <?php echo app('translator')->get('Don\'t have an account'); ?> <a class="have-account__link underline-with-text" href="<?php echo e(route('user.register')); ?>"><?php echo app('translator')->get('Sign Up'); ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/auth/login.blade.php ENDPATH**/ ?>