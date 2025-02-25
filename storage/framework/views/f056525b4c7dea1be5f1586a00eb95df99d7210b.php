<?php $__env->startSection('content'); ?>
    <?php
        $kycInfo = getContent('kyc_info.content', true);
        $themeColor = $general->theme_color ?? '#007bff';
    ?>
    <div class="row g-3 mb-3">
        <?php if(auth()->user()->kv == 0): ?>
            <div class="col-12">
                <div class="alert alert-info text-center p-3 border-0 shadow-sm">
                    <h6 class="mb-1 fw-bold"><?php echo app('translator')->get('KYC Verification Required'); ?></h6>
                    <p class="mb-0 small">
                        <?php echo e(__($kycInfo->data_values->verification_content)); ?>

                        <a href="<?php echo e(route('user.kyc.form')); ?>" class="fw-bold text-primary"><?php echo app('translator')->get('Click Here to Verify'); ?></a>
                    </p>
                </div>
            </div>
        <?php elseif(auth()->user()->kv == 2): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center p-3 border-0 shadow-sm">
                    <h6 class="mb-1 fw-bold"><?php echo app('translator')->get('KYC Verification Pending'); ?></h6>
                    <p class="mb-0 small">
                        <?php echo e(__($kycInfo->data_values->pending_content)); ?>

                        <a href="<?php echo e(route('user.kyc.data')); ?>" class="fw-bold text-primary"><?php echo app('translator')->get('See KYC Data'); ?></a>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <form action="<?php echo e(route('user.ptc.confirm')); ?>" method="POST" onsubmit="return <?php echo e($earningClaimed ? 'false' : 'true'); ?>;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn fw-bold claim-btn" id="<?php echo e($earningClaimed ? 'counter' : ''); ?>">
                <i class="fas fa-coins me-1"></i> <?php echo app('translator')->get('Claim Daily Earning'); ?>
            </button>
        </form>

    </div>
    <div class="row g-3">
        <?php $__currentLoopData = [
            ['route' => 'transactions', 'label' => 'Available Balance', 'value' => showAmount($user->balance) . ' ' . __($general->cur_text), 'icon' => 'fas fa-wallet'],
            ['route' => 'transactions?search=&trx_type=%2B&remark=', 'label' => 'Today Earnings', 'value' => showAmount($dailyEarning) . ' ' . __($general->cur_text), 'icon' => 'fas fa-calendar-day'],
            ['route' => 'transactions?search=&trx_type=%2B&remark=', 'label' => 'Total Earnings', 'value' => showAmount($user->total_earning) . ' ' . __($general->cur_text), 'icon' => 'fas fa-dollar-sign'],
            ['route' => 'commissions', 'label' => 'Referral Earnings', 'value' => $commissionCount . ' ' . __($general->cur_text), 'icon' => 'fas fa-user-friends'],
            ['route' => 'transactions?search=&trx_type=&remark=subscribe_plan', 'label' => 'Total Investment', 'value' => showAmount($user->total_investment) . ' ' . __($general->cur_text), 'icon' => 'fas fa-chart-line'],
            ['route' => 'deposit/history', 'label' => 'Total Deposits', 'value' => showAmount($user->deposits->where('status', 1)->sum('amount')) . ' ' . __($general->cur_text), 'icon' => 'fas fa-university'],
            ['route' => 'withdraw/history', 'label' => 'Total Withdrawn', 'value' => showAmount($user->withdrawals->where('status', 1)->sum('amount')) . ' ' . __($general->cur_text), 'icon' => 'fas fa-money-bill-wave'],
            ['route' => 'referred-users/b&c', 'label' => 'My Plan', 'value' => optional($user->plan)->name ?? 'No Plan' , 'icon' => 'fas fa-star'],
            ['route' => 'referred-users', 'label' => 'Direct Members', 'value' => $user->reffer->count() . ' User(s)', 'icon' => 'fas fa-users'],
            ['route' => 'referred-users/b&c', 'label' => 'Total Team', 'value' => $refferUsers . ' User(s)', 'icon' => 'fas fa-network-wired'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card stats-card shadow-sm border-0 p-3 text-center"
                    onclick="window.location.href='<?php echo e($stat['route']); ?>'" style="cursor: pointer;">
                    <div class="icon-container" style="background: <?php echo e($themeColor); ?>;">
                        <i class="<?php echo e($stat['icon']); ?>"></i>
                    </div>
                    <p class="small text-muted mb-1"><?php echo e(__($stat['label'])); ?></p>
                    <h6 class="fw-bold mb-0"><?php echo e($stat['value']); ?> </h6>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php if($general->notification_modal): ?>
        <div class="modal fade" id="notificationModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="modal-header bg-gradient text-white py-4"
                        style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                        <h5 class="modal-title fw-bold">🚀 <?php echo app('translator')->get('Important Notification'); ?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 text-center" style="max-height: 400px; overflow-y: auto;">
                        <div class="d-flex flex-column align-items-center">
                            <div class="icon-container mb-4"
                                style="width: 70px; height: 70px; background: #6a11cb; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                                <i class="fas fa-bell text-white" style="font-size: 48px;"></i>
                            </div>
                            <p class="lead text-dark mb-4"><?php echo __($general->modal_text); ?></p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center bg-light">
                        <button type="button" class="btn btn-primary rounded-pill px-5 py-3 fw-bold"
                            data-bs-dismiss="modal"><?php echo app('translator')->get('Got It!'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .claim-btn {
            background: linear-gradient(135deg, <?php echo e($themeColor); ?>, #ff8c00);
            border: none;
            color: white;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 6px;
            transition: 0.3s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .claim-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ff8c00, <?php echo e($themeColor); ?>);
        }

        .stats-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease-in-out;
        }

        .stats-card:hover {
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
            transform: scale(1.03);
        }

        .icon-container {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #ffffff;
            font-size: 20px;
            margin: 0 auto 8px;
        }

        .modal-content {
            animation: slideDown 0.6s ease-out, glow 1.5s infinite alternate;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 15px #6a11cb;
            }

            to {
                box-shadow: 0 0 25px #2575fc;
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: scale(1.1);
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background-color: #6a11cb;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let modal = new bootstrap.Modal(document.getElementById("notificationModal"));
            let lastClosed = localStorage.getItem("modalLastClosed");
            if (!lastClosed || (Date.now() - lastClosed > 7200000)) {
                modal.show();
            }
            document.getElementById("notificationModal").addEventListener("hidden.bs.modal", function() {
                localStorage.setItem("modalLastClosed", Date.now().toString());
            });
        });

        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes +
                    "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "<?php echo e(__('COMPLETE')); ?>";
                }
                tms--;
            }, 1000);
        }
        createCountDown('counter', <?php echo e(\Carbon\Carbon::tomorrow()->diffInSeconds()); ?>);
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/dashboard.blade.php ENDPATH**/ ?>