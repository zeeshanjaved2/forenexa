<?php $__env->startSection('content'); ?>
    <div class="table-responsive">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th><?php echo app('translator')->get('Full Name'); ?></th>
                    <th><?php echo app('translator')->get('User Name'); ?></th>
                    <th><?php echo app('translator')->get('Email'); ?></th>
                    <th><?php echo app('translator')->get('Mobile'); ?></th>
                    <th><?php echo app('translator')->get('Plan'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $refUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(__($log->fullname)); ?></td>
                        <td><?php echo e(__($log->username)); ?></td>
                        <td><?php echo e($log->email); ?></td>
                        <td><?php echo e($log->mobile); ?></td>
                        <td><?php echo e(__($log->plan ? $log->plan->name : 'No Plan')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center" colspan="100%"> <?php echo e(__($emptyMessage)); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <?php echo e(paginateLinks($refUsers)); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Laravel Project\ui-ads-new\resources\views/templates/ptc_prime/user/referred_BC.blade.php ENDPATH**/ ?>