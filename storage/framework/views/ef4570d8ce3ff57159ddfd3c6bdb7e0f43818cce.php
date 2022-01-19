<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>


<div class="blog-detail">
    <div class="post-detail">
        <h2 class="post-title font-weight-bold"><?php echo e($article->title); ?></h2>
        <div class="info-post">
            <i class="icon mdi mdi-account rounded-circle"></i>
            Đăng bởi: <?php echo e($article->getAuthor()->name); ?>

            <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
            Đăng ngày: <?php echo e($article->dateFormat('d.m.Y')); ?>

        </div>
        <div class="post-content">
            <?php echo e($article->description); ?>

            <img src="<?php echo e($article->getImage()); ?>" alt="">
            <div class="detail-content">
                <?php echo $article->content; ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>