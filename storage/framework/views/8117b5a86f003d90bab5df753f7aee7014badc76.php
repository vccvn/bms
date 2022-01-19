<?php $__env->startSection('content'); ?>

    <div class="home-page">

        <?php echo $__env->make($__current.'templates.slider', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__templates.'trip-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Uư diêm -->

        <?php echo $__env->make($__current.'templates.featured', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- block bài viết -->

        <?php echo $__env->make($__current.'templates.posts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo $__env->make($__utils.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>