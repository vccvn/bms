<div class="sidebar">

    <div class="orther-list mb-4">
        <h5>Tìm kiếm</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>
        <div class="search-form-block">
            <form action="<?php echo e(route('client.search')); ?>" method="get">
                <div class="form-group">
                    <div class="input-group">
                        <input type="search" name="s" class="form-control" placeholder="Nhập từ khóa...">
                        <button type="submit" class="btn btn-warning input-group-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(count($lastest_posts = get_posts(['@orderBy'=>['id','DESC'], '@limit'=>5]))): ?>
    


    <div class="orther-list">
        <h5>Bài viết mới nhất</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>

        <div class="post-list row">
            <?php $__currentLoopData = $lastest_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
            
            <div class="post-item col-lg-12 col-md-6 col-sm-6 col-12 mb-4">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <a href="<?php echo e($u = $item->getViewUrl()); ?>">
                            <img src="<?php echo e($item->getImage()); ?>" alt="<?php echo e($item->slug); ?>">
                        </a>
                    </div>
                    <div class="col-12 col-sm-8">
                        <a href="<?php echo e($u); ?>" class="text-dark"><?php echo e($item->title); ?></a>
                    </div>
                                        
                </div>
                
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>

<?php endif; ?>

<?php if(count($categories = get_categories(['@orderBy'=>['id','DESC'], '@limit'=>5]))): ?>
    


    <div class="orther-list">
        <h5>Thể loại</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>

        <ul class="categories">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="category-item">
                    <a href="<?php echo e($u = $item->getViewUrl()); ?>">
                        <?php echo e($item->name); ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            

        </ul>
    </div>

<?php endif; ?>

</div>