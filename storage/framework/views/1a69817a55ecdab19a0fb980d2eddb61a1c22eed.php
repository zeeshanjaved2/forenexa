<?php $__env->startSection('content'); ?>

    <div class="dashboard-table__header d-flex justify-content-end pt-0 px-0">
        <div class="dashboard-table__btn">
            <a class="btn btn--sm btn-outline--base" href="<?php echo e(route('ticket.open')); ?>"> <i class="las la-plus"></i> <?php echo app('translator')->get('New Ticket'); ?></a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th><?php echo app('translator')->get('Subject'); ?></th>
                    <th><?php echo app('translator')->get('Status'); ?></th>
                    <th><?php echo app('translator')->get('Priority'); ?></th>
                    <th><?php echo app('translator')->get('Last Reply'); ?></th>
                    <th><?php echo app('translator')->get('Action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td> <a class="fw-bold" href="<?php echo e(route('ticket.view', $support->ticket)); ?>"> [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?> </a></td>
                        <td>
                            <?php echo $support->statusBadge; ?>
                        </td>
                        <td>
                            <?php if($support->priority == Status::PRIORITY_LOW): ?>
                                <span class="badge badge--dark"><?php echo app('translator')->get('Low'); ?></span>
                            <?php elseif($support->priority == Status::PRIORITY_MEDIUM): ?>
                                <span class="badge badge--warning"><?php echo app('translator')->get('Medium'); ?></span>
                            <?php elseif($support->priority == Status::PRIORITY_HIGH): ?>
                                <span class="badge badge--danger"><?php echo app('translator')->get('High'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(diffForHumans($support->last_reply)); ?> </td>

                        <td>
                            <a class="btn btn-outline--base btn--sm" href="<?php echo e(route('ticket.view', $support->ticket)); ?>">
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

    <?php echo e($supports->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/support/index.blade.php ENDPATH**/ ?>