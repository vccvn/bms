

                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($loop->index%2==0): ?>
                <div class="row">
                <?php endif; ?>    
                
                    <!--News Block-->
                    <div class="news-block col-md-6 col-sm-6 col-xs-12">
                        <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <figure class="image-box">
                                <a href="<?php echo e($item->getViewUrl()); ?>"><img src="<?php echo e($item->getFeatureImage()); ?>" alt="<?php echo e($item->title); ?>" /></a>
                                <a class="read-more" href="<?php echo e($item->getViewUrl()); ?>">Đọc tiếp <span class="icon fa fa-long-arrow-right"></span></a>
                            </figure>
                            <div class="lower-content">
                                <div class="upper-box">
                                    <h3><a href="<?php echo e($item->getViewUrl()); ?>"><?php echo e($item->title); ?></a></h3>
                                    <div class="lower-box">
                                        <div class="date"><?php echo e($item->dateFormat('d/m/Y')); ?> / <a href="<?php echo e($item->getViewUrl()); ?>"><?php echo e($item->comment_count?$item->comment_count:0); ?> bình luận</a></div>
                                    </div>
                                    <div class="text"><?php echo e($item->getShortDesc(60)); ?> </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    
                <?php if($loop->index%2==1 || $loop->last): ?>
                </div>

                <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
