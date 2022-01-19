<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

            <section>
                <div class="container">
                    <div class="contact posts">
                        <div class=" about-detail">
                            <h2 class="title text-left"><?php echo e($page_title); ?></h2>
                            <hr class="divider">
                            <?php if(count($list)): ?>
                                <div class="range posts-list row">
                                
                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
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
                                
                                </div>

                            
                            <?php echo e($list->links('vendor.pagination.bs4')); ?>


                            <?php else: ?>
                            
                                <div class="alert alert-info">Không có kết quả phù hợp</div>
                            
                            <?php endif; ?>
                            
                            <?php $__env->stopSection(); ?>
                        </div>
                    </div>
                </div>
            </section>
<?php echo $__env->make($__layouts.'single', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>