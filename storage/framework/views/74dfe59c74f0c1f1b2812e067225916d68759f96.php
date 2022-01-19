<?php echo $__env->make($__utils.'register-meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('content'); ?>

                    <!--News details-->
                    <div class="blog-detail">
						
                        <!--News Block-->
                        <div class="news-block">
                            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <figure class="image-box">
                                    <img src="<?php echo e($article->getFeatureImage()); ?>" alt="" />
                                </figure>
                                <div class="lower-content">
                                    <div class="upper-box">
                                        <h3><?php echo e($article->title); ?></h3>
                                        <div class="lower-box">
                                            <div class="date"><i class="fa fa-calendar"></i> <?php echo e($article->dateFormat('d-m-Y')); ?> / <a href="<?php echo e($article->category->getViewUrl()); ?>"> <i class="fa fa-folder-open"></i> <?php echo e($article->category->name); ?></a> / <a href="#comments"><i class="fa fa-comment"></i> <?php echo e($article->comment_count?$article->comment_count:0); ?> bình luận</a></div>
                                        </div>
                                        <div class="text"><?php echo $article->content; ?></div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <!--Post Share Options-->
                            <div class="post-share-options clearfix">
                                <?php echo $__env->make($__templates.'post-tags',['tags'=>$article->getTags()], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>
                        
                        <?php echo $__env->make($__utils.'social-buttons', [
                            'link'=>$article->getViewUrl(),
                            'title' => $article->title
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    	<!--Comments Area-->
                        <?php echo $__env->make($__templates.'comments',[
                            'comments'=>$article->publishComments,
                            'object' => $article->type,
                            'object_id' => $article->id,
                            'link' => $article->getViewUrl()
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                   		

                   	</div>
                

<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>