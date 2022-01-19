<?php $__env->startSection('title', "Tin bài"); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Tin bài
                        <a href="<?php echo e(route('admin.post.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        <?php echo $__env->make($__templates.'list-filter',['filter_list'=>['title'=>'Tiêu đề','category'=>'Danh mục','views'=>'Lượt xem','created_at' => 'Thời gian']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($list->count()>0): ?>
        <ul class="item-list striped list-body list-post">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header fixed item-col-img md">
                        <div>
                            <span>Ảnh</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Tiêu đề bài viết</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Danh mục</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Lượt xem</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same item-col-stats"> </div>
                </div>
            </li>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="item" id="post-item-<?php echo e($item->id); ?>">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="posts[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="<?php echo e($item->getUpdateUrl()); ?>">
                            <div class="item-img rounded" style="background-image: url(<?php echo e($item->getFeatureImage()); ?>)"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tiêu đề</div>
                        <div>
                            <a href="<?php echo e($item->getUpdateUrl()); ?>" class="">
                                <h4 class="item-title" id="post-title-<?php echo e($item->id); ?>"> <?php echo e($item->title); ?> </h4>
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            <?php echo e($item->category->name); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div class="no-overflow">
                            <?php echo e($item->getShortDesc(64)); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Lượt xem</div>
                        <div class="no-overflow">
                            <?php echo e($item->views); ?>

                        </div>
                    </div>
                    <div class="item-col fixed item-col-stats item-col-same pull-right">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit btn btn-sm btn-success">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-post btn btn-danger btn-sm" data-id="<?php echo e($item->id); ?>">
                                        <i class="fa fa-trash-o"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-post"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        <?php echo e($list->links('vendor.pagination.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger text-center">
            Danh sách trống
        </div>
        <?php endif; ?>    
    </div>
    



</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.postsInit = function() {
        Cube.posts.init({
            urls:{
                delete_url: '<?php echo e(route('admin.post.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>