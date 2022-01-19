

                        <aside class="sidebar blog-sidebar">

                            <!-- Search Form -->
                            <div class="sidebar-widget search-box">
                                <div class="sidebar-title"><h2>Tìm kiếm</h2></div>
                                <form method="get" action="<?php echo e(route('client.search')); ?>">
                                    <div class="form-group">
                                        <input type="search" name="s" value="" placeholder="Nhập từ khóa">
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>
                            

                            <?php if(count($categories = get_pupular_category_list())): ?>

                            <!-- Categories -->
                            <div class="sidebar-widget recent-articles wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Chuyên mục</h2></div>
                                <ul class="list">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($cate->getViewUrl()); ?>" class="clearfix"><?php echo e($cate->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            
                            <?php endif; ?>
                            
                            <?php if(count($posts = get_post_list(['@order_by'=>['created_at'=>'DESC'],'@limit'=>6]))): ?>

                            <!-- Popular Posts -->
                            <div class="sidebar-widget popular-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Bài viết gần đây</h2></div>
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <article class="post">
                                    <figure class="post-thumb"><a href="<?php echo e($p->getViewUrl()); ?>"><img src="<?php echo e($p->getFeatureImage('90x90')); ?>" alt="<?php echo e($p->title); ?>"></a></figure>
                                    <h4><a href="<?php echo e($p->getViewUrl()); ?>"><?php echo e($p->title); ?></a></h4>
                                    <div class="post-info"><?php echo e($p->dateFormat('d/m/Y')); ?> / <a href="<?php echo e($p->getViewUrl()); ?>"><?php echo e($p->comment_count?$p->comment_count:0); ?> Bình luận</a></div>
                                </article>
                                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </div>
                            <?php endif; ?>

                            <?php if($tags = get_popular_tags(['@limit'=>6])): ?>
                            <!-- Tags -->
                            <div class="sidebar-widget popular-tags wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Từ khóa nổi bật</h2></div>
                                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <a href="<?php echo e(route('client.search',['s'=>$tag->lower])); ?>"><?php echo e($tag->keywords); ?></a>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <?php endif; ?>
                        </aside>

                        