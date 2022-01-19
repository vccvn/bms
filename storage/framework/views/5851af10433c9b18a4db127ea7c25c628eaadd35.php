<?php $__env->startSection('content'); ?>
<section>
            <div class="container">
                <div class="contact posts row">
                    <div class=" about-detail">
                        <h2 class="title text-left">Bài viết</h2>
                        <hr class="divider">
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
                           <!-------------------------- -->
                       
                       <!-------------------------- -->
                            <nav class="mt-5">
                                <ul class="pagination pagination-lg">
                                    <li class="page-item disabled ">
                                        <a class="page-link " href="#" tabindex="-1">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>