<?php $__env->startSection('title', 'Crawl Task'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Task
                        <a href="<?php echo e(route('admin.crawler.task.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        <?php echo $__env->make($__templates.'list-filter',[
            'filter_list'=>[
                'url' => 'Dường dẫn',
                'created_at' => 'Thời gian'
            ]
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($list->count()>0): ?>
        <ul class="item-list striped list-body list-task">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Dường dẫn</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Kênh</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Danh mục</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Nguồn</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Thời gian</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Trạng thái</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same-md item-col-stats">
                        <div class="no-overflow">
                            <span>Hành động</span>
                        </div>
                    </div>
                </div>
            </li>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $category = $item->category; $frame = $item->frame; $author = $item->author; ?>
            <li class="item" id="task-item-<?php echo e($item->id); ?>">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="frames[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Dường dẫn</div>
                        <div>
                            <h4 class="item-title" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->url); ?>"> 
                                <a href="<?php echo e($item->url); ?>" class=""><?php echo e($item->url); ?></a>
                            </h4>
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            <?php echo e($item->getChannelName()); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            <?php echo e($category?$category->name:'Không'); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Nguồn</div>
                        <div class="no-overflow">
                            <a href="<?php echo e($frame?$frame->url:''); ?>"><?php echo e($frame?$frame->name:'nudefined'); ?></a>
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Thời gian</div>
                        <div class="no-overflow">
                            <?php echo e($item->getTimeAgo()); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-same-sm">
                        <div class="item-heading">Trạng thái</div>
                        <div class="">
                            <div class="btn-group task-status-select select-dropdown">
                                <button type="button" class="btn btn-secondary text-<?php echo e($item->status?'primary':'secondary'); ?> btn-sm dropdown-toggle status-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo e($item->getStatusText()); ?>

                                </button>
                                <div class="dropdown-menu status-select select-dropdown-menu">
                                    <?php $__empty_1 = true; $__currentLoopData = $item->getStatusMenu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a data-id="<?php echo e($item->id); ?>" data-status="<?php echo e($st); ?>" id="task-item-<?php echo e($item->id); ?>-<?php echo e($st); ?>" href="#" title="chuyển sang <?php echo e($t); ?>" class="dropdown-item nav-link pt-1 pb-1 <?php echo e($st==$item->status?'active':''); ?>"> <?php echo e($t); ?> </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                    <?php endif; ?>
                                </div>    
                            </div>
                        </div>
                    </div>
                    
                    <div class="item-col fixed item-col-stats item-col-same-md pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-center">
                                <li>
                                    <a href="#" class="run btn-run-task text-warning" data-id="<?php echo e($item->id); ?>">
                                        <i class="fa fa-copy"></i> Crawl
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit text-success">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-task text-danger" data-id="<?php echo e($item->id); ?>" title="xóa">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
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
                    <a href="#" class="btn btn-sm btn-success btn-run-all-task"><i class="fa fa-bolt"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-task"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        <?php echo e($list->links('vendor.pagination.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
        <?php endif; ?>
        
    </div>
    
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.crawler.task.delete')); ?>'
            }
        });
    };
    window.tasksInit = function() {
        Cube.tasks.init({
            urls:{
                delete_url: '<?php echo e(route('admin.crawler.task.delete')); ?>',
                run_url: '<?php echo e(route('admin.crawler.task.run')); ?>',
                change_status_url:  '<?php echo e(route('admin.crawler.task.status')); ?>',
                view_url: '<?php echo e(route('admin.order.view')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/admin/tasks.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>