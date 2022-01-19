<?php 
$category = isset($parent)?$parent:null;
$layout = ($article->layout && in_array($article->layout, ['single', 'sidebar']))?$article->layout:'sidebar';

?>


<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

<?php if($layout!='sidebar'): ?>
    <?php if($article->display_content): ?>
        <?php echo $article->content; ?>

    <?php else: ?>
    <div class="container-fluid">

        <div class="blog-detail">
            <div class="post-detail">
                <div class="thumb">
                        <img src="<?php echo e($article->getImage()); ?>" alt="<?php echo e($article->slug); ?>">
                </div>
                <h2 class="post-title font-weight-bold"><?php echo e($article->title); ?></h2>
                <div class="info-post">
                    <i class="icon mdi mdi-account rounded-circle"></i>
                    Đăng bởi: <?php echo e($article->getAuthor()->name); ?>

                    <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                    Đăng ngày: <?php echo e($article->dateFormat('d.m.Y')); ?>

                </div>
                <div class="post-content">
                    
                    <div class="detail-content">
                        <?php echo $article->content; ?>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
        
    <?php endif; ?>    
<?php else: ?>
    <?php if($article->display_content): ?>
    <?php echo $article->content; ?>

    <?php else: ?>
        
    <div class="blog-detail">
        <div class="post-detail">
            <div class="thumb">
                    <img src="<?php echo e($article->getImage()); ?>" alt="<?php echo e($article->slug); ?>">
            </div>
            <h2 class="post-title font-weight-bold"><?php echo e($article->title); ?></h2>
            <div class="info-post">
                <i class="icon mdi mdi-account rounded-circle"></i>
                Đăng bởi: <?php echo e($article->getAuthor()->name); ?>

                <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                Đăng ngày: <?php echo e($article->dateFormat('d.m.Y')); ?>

            </div>
            <div class="post-content">
                
                <div class="detail-content">
                    <?php echo $article->content; ?>

                </div>
            </div>
        </div>
    </div>
    
    <?php endif; ?>
<?php endif; ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.$layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>