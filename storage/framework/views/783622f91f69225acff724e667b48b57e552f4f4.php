<?php $__env->startSection('title', '403 - Forbidden'); ?>


<?php $__env->startSection('content'); ?>


<div class="app blank sidebar-opened">
    <article class="content">
        <div class="error-card global">
            <div class="error-title-block">
                <h1 class="error-title">403</h1>
                <h2 class="error-sub-title"> Forbidden. </h2>
            </div>
            <div class="error-container">
                <p>Why not try refreshing your page? or you can contact support</p>
                <a class="btn btn-primary" href="#">
                    <i class="fa fa-angle-left"></i> Back to Website </a>
            </div>
        </div>
    </article>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('panel._layouts.clean', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>