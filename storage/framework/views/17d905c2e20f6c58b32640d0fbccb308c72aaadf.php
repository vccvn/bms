<?php $__env->startSection('content'); ?>

                   <section>
            <div class="container">
                <div class="blog-detail row">
                    <div class="col-md-8 post-detail">
                        <h2 class="post-title"><?php echo e($posts->title); ?></h2>
                        <div class="info-post">
                            <i class="icon mdi mdi-account rounded-circle"></i>
                            <?php echo e($author->getAuthor($posts->user_id)->name); ?>

                            <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                            Đăng ngày: <?php echo e($posts->created_at->format('d/m/Y')); ?>

                        </div>
                        <div class="post-content">
                            <?php echo $posts->content; ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="adds"></div>
                    </div>
                </div>
            </div>
        </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>