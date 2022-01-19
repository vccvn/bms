<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
?>


<?php $__env->startSection('title','Tìm kiếm'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make($__current.'header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
            
            <section class="search-section">
                <div class="search-result">
                    <div class="results">
                        <div class=" about-detail">
                            <h3 class="title-search text-left">Kết quã tìm kiếm cho: <span class="text-danger"><?php echo e($search); ?></span></h3>
                            <hr class="divider">
                            <?php if(count($list)): ?>
                                <div class="range posts-list row">
                                
                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-6 col-md-12 col-lg-6 mb-4">
                                        <div class="post-item row">
                                            <div class="post-thumb col-md-6 col-lg-12">
                                                <a href="<?php echo e($u = $item->getViewUrl()); ?>">
                                                    <img src="<?php echo e($item->getImage()); ?>" alt="">
                                                </a>
                                                    
                                            </div>
                                            <div class="post-info col-md-6 col-lg-12">
                                                <div class="post-item-title">
                                                    <h4>
                                                        <a href="<?php echo e($u); ?>"><?php echo e($item->title); ?></a>
                                                    </h4>
                                                    
                                                </div>
                                                <div class="post-item-meta">
                                                    <span><i class="far fa-calendar-alt"></i></span>
                                                    <span><?php echo e($item->calculator_time('created_at')); ?> </span>
                                                    <span class="ml-2"><i class="fa fa-user"></i></span>
                                                    <span class="p-1">  <?php echo e($item->getAuthor()->name); ?></span>
                                                </div>
                                                <div class="post-item-desc mt-2">
                                                    <?php echo e($item->getShortDesc(120)); ?>

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
                            
                            
                        </div>
                    </div>
                </div>
            </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'clean', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>