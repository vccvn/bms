<?php if(count($posts)): ?>
    
<section class="section-90 section-111 bg-zircon" >
    <div class="container">
        <div class="posts">
            <h2 class="title">Bài viết mới </h2>
            <div class="divider"></div>   
            <div class="range posts-list">
                
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                <div class="col-md-6 ">
                    <div class="post-item linear">
                        <a href="<?php echo e($u = $item->getViewUrl()); ?>">
                            <img src="<?php echo e($item->getImage()); ?>" alt="">
                        </a>
                        <div class="post-content">
                            <div class="post-tags">
                                <?php if(count($tags = $item->getTags())): ?>
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($tag->keywords); ?> </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                
                            </div>
                            <div class="post-body">
                                <div class="post-title">
                                    <h4>
                                        <a href="<?php echo e($u); ?>" class="text-white"><?php echo e($item->title); ?></a>
                                    </h4>
                                    
                                </div>
                                <div class="post-meta">
                                    <i class="far fa-calendar-alt text-white"></i>
                                    <span><?php echo e($item->calculator_time('created_at')); ?> </span>
                                    <span class="text-white ml-3">bởi</span>
                                    <span class="p-1"> <?php echo e($item->getAuthor()->name); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------- -->

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="view-all col-12 text-center">
                    <a href="<?php echo e(route('client.post')); ?>" class="btn">
                        Xem thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>
