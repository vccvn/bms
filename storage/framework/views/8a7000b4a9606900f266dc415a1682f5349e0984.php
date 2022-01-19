<?php $__env->startSection('content'); ?>
        <?php echo $__env->make($__current.'templates.services', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--News Section-->
        <?php echo $__env->make($__current.'templates.posts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--News Section-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__theme.'_layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>