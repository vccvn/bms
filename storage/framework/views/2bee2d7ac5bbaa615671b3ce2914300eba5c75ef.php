<section >
            <div class="container">
                <div class="posts">
                    <h2 class="title">Bài viết mới </h2>
                    <div class="divider"></div>   
                    <div class="range posts-list">
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="post-item">
                                <img src="<?php echo e($value->getImage()); ?>" alt="">
                                <div class="post-content">
                                    <div class="post-tags">
                                        <span>Tin tức </span>
                                    
                                    </div>
                                    <div class="post-body">
                                        <div class="post-title">
                                            <a href="<?php echo e(url('tin-tuc/'.$value->slug)); ?>">
                                                <h4> <?php echo e($value->title); ?> </h4>
                                            </a>
                                        </div>
                                        <div class="post-meta">
                                            <i class="far fa-calendar-alt text-white"></i>
                                            <span> <?php echo e($value->created_at->format('d/m/Y')); ?> </span>
                                            <span class="text-white ml-3">bởi</span>
                                            <span class="p-1"><?php echo e($author->getAuthor($value->user_id)->name); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>         
                        <div class="view-all">
                            <a href="blog.html" class="btn">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>