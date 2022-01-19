<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($list)): ?>

    <?php echo $__env->make($__current.'templates.list-style-default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo e($list->links('vendor.pagination.corpro')); ?>


<?php else: ?>

    <div class="alert alert-info">Không có kết quả phù hợp</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>