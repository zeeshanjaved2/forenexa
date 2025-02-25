<?php $__env->startSection('content'); ?>
    <?php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $registerContent = getContent('register.content', true);
    ?>

    <section class="account py-120">
        <div class="container">
            <div class="row justify-content-center gy-4">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4 text-center">
                            <h3 class="account-form__title mb-2"> <?php echo e(__($registerContent->data_values->heading)); ?> </h3>
                            <p class="account-form__desc"> <?php echo e(__($registerContent->data_values->subheading)); ?> </p>
                        </div>
                        <form class="verify-gcaptcha" action="<?php echo e(route('user.register')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <?php if(session()->get('reference') != null): ?>
                                    <div class="col-sm-12 form-group">
                                        <div class="form--group">
                                            <label class="form--label" for="referenceBy"><?php echo app('translator')->get('Reference by'); ?></label>
                                            <input class="form--control" id="referenceBy" name="referBy" type="text" value="<?php echo e(session()->get('reference')); ?>" readonly>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-6 form-group">
                                    <label class="form--label"><?php echo app('translator')->get('First Name'); ?></label>
                                    <input class="form--control" name="firstname" type="text" value="<?php echo e(old('firstname')); ?>" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Last Name'); ?></label>
                                    <input class="form--control" name="lastname" type="text" value="<?php echo e(old('lastname')); ?>" required>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="form--group">
                                        <label class="form--label"><?php echo app('translator')->get('Username'); ?></label>
                                        <input class="form--control checkUser" name="username" type="text" value="<?php echo e(old('username')); ?>" required>
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="form--group">
                                        <label class="form--label"><?php echo app('translator')->get('E-Mail Address'); ?></label>
                                        <input class="form--control checkUser" name="email" type="email" value="<?php echo e(old('email')); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                    <div class="position-relative">
                                        <input class="form-control form--control <?php if($general->secure_password): ?> secure-password <?php endif; ?>" id="password" name="password" type="password" required>
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                    <div class="position-relative">
                                        <input class="form-control form--control" id="confirm-password" name="password_confirmation" type="password" required>
                                        <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#confirm-password"></div>
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
                                <?php if($general->agree): ?>
                                <div class="col-sm-12">
                                    <div class="form--check form-group">
                                        <input class="form-check-input" type="checkbox" id="agree" <?php if(old('agree')): echo 'checked'; endif; ?> name="agree" required>
                                        <div class="form-check-label">
                                            <label for="agree"><?php echo app('translator')->get('I agree with'); ?></label> <span><?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="<?php echo e(route('policy.pages',[slug($policy->data_values->title),$policy->id])); ?>" class="text--base" target="_blank"><?php echo e(__($policy->data_values->title)); ?></a> <?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-12 form-group">
                                    <button class="btn btn--base w-100" type="submit"> <?php echo app('translator')->get('Sign Up'); ?> </button>
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
                                                <?php echo app('translator')->get('Google'); ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if($credentials->facebook->status == Status::ENABLE): ?>
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="<?php echo e(route('user.social.login', 'facebook')); ?>">
                                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/thumbs/facebook.png')); ?>" alt="">
                                                <?php echo app('translator')->get('Facebook'); ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if($credentials->linkedin->status == Status::ENABLE): ?>
                                            <a class="btn btn-outline--base signup-btn flex-fill" type="submit" href="<?php echo e(route('user.social.login', 'linkedin')); ?>">
                                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/thumbs/linkedin.png')); ?>" alt="">
                                                <?php echo app('translator')->get('Linkdin'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text"><?php echo app('translator')->get('Already have an account'); ?> <a class="have-account__link underline-with-text" href="<?php echo e(route('user.login')); ?>"><?php echo app('translator')->get('Sign In'); ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle"><?php echo app('translator')->get('You are with us'); ?></h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center"><?php echo app('translator')->get('You already have an account please Login '); ?></h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button"><?php echo app('translator')->get('Close'); ?></button>
                    <a class="btn btn--base btn--sm" href="<?php echo e(route('user.login')); ?>"><?php echo app('translator')->get('Login'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if($general->secure_password): ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset('assets/global/js/secure_password.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            <?php if($mobileCode): ?>
                $(`option[data-code=<?php echo e($mobileCode); ?>]`).attr('selected', '');
            <?php endif; ?>

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '<?php echo e(route('user.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/auth/register.blade.php ENDPATH**/ ?>