<?php 
$category = isset($parent)?$parent:null;

?>



<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->startSection('content'); ?>

    <div class="alert alert-danger">Trang bạn truy cập hiện không khả dụng</div>
                

<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>