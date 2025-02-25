<?php $__env->startSection('content'); ?>
    <div class="dashboard-table__header d-flex justify-content-end pt-0 px-0">
        <div class="dashboard-table__btn">
            <form class="dashboard-form" action="">
                <div class="input-group">
                    <input class="form--control form-control" name="search" type="text" value="<?php echo e(request()->search); ?>" placeholder="<?php echo app('translator')->get('Search by transactions'); ?>">
                    <button class="input-group-text bg--base text-white">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card custom--card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table--responsive--lg table">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Gateway | Transaction'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Initiated'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Amount'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Conversion'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Details'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold"> <span class="text-primary"><?php echo e(__($deposit->gateway?->name)); ?></span> </span>
                                        <br>
                                        <small> <?php echo e($deposit->trx); ?> </small>
                                    </div>
                                </td>

                                <td class="text-end text-md-center">
                                    <div>
                                        <span class="d-block"><?php echo e(showDateTime($deposit->created_at)); ?> </span>
                                        <span><?php echo e(diffForHumans($deposit->created_at)); ?></span>

                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    <div>
                                        <?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($deposit->amount)); ?> + <span class="text-danger" title="<?php echo app('translator')->get('charge'); ?>"><?php echo e(showAmount($deposit->charge)); ?> </span>
                                        <br>
                                        <strong title="<?php echo app('translator')->get('Amount with charge'); ?>">
                                            <?php echo e(showAmount($deposit->amount + $deposit->charge)); ?> <?php echo e(__($general->cur_text)); ?>

                                        </strong>
                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    <div>
                                        1 <?php echo e(__($general->cur_text)); ?> = <?php echo e(showAmount($deposit->rate)); ?> <?php echo e(__($deposit->method_currency)); ?>

                                        <br>
                                        <strong><?php echo e(showAmount($deposit->final_amo)); ?> <?php echo e(__($deposit->method_currency)); ?></strong>
                                    </div>
                                </td>
                                <td class="text-end text-md-center">
                                    <?php echo $deposit->statusBadge ?>
                                </td>
                                <?php
                                    $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                ?>

                                <td>
                                    <a class="btn btn-outline--base btn--sm <?php if($deposit->method_code >= 1000): ?> detailBtn <?php else: ?> disabled <?php endif; ?>" href="javascript:void(0)" <?php if($deposit->method_code >= 1000): ?> data-info="<?php echo e($details); ?>" <?php endif; ?> <?php if($deposit->status == Status::PAYMENT_REJECT): ?> data-admin_feedback="<?php echo e($deposit->admin_feedback); ?>" <?php endif; ?>>
                                        <i class="las la-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if($deposits->hasPages()): ?>
    <?php echo e($deposits->links()); ?>

   <?php endif; ?>
    
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Details'); ?></h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button"><?php echo app('translator')->get('Close'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong><?php echo app('translator')->get('Admin Feedback'); ?></strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/deposit_history.blade.php ENDPATH**/ ?>