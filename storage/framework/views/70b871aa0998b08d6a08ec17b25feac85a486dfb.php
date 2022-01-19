<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$types = ['direct' => 'Cố định','indirect' => 'Trung gian', 'bus' => 'Buýt'];

?>




<?php $__env->startSection('title', 'Tỉnh thành'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Tuyến xe
                        <a href="<?php echo e(route('admin.route.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
    <div class="card items">
        <?php echo $__env->make('admin._templates.search-filter',[
            'search_filter'=>[
                'name' => 'Tên tuyến',
                'end_station' => 'Tên bến xe',
                'to_province' => 'Tên tỉnh thành'
            ]
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($list->count()>0): ?>
        <ul class="item-list striped list-body list-item">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-title">
                        <div>
                            <span>Tên Tuyến xe</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Loại</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Bến đầu tuyến</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Bến cuối tuyến</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div>
                            <span>Lộ trình</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Chiều dài</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Chuyến</span>
                        </div>
                    </div>
                    
                    
                    <div class="item-col item-col-header fixed item-col-stats"> 
                        <span>actions</span>
                    </div>
                </div>
            </li>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="item" id="item-<?php echo e($item->id); ?>">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="comments[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed pull-left item-col-title item-col-same-sm">
                        <div class="item-heading">Tên tuyến xe</div>
                        <div>
                            
                            <h4 class="item-title" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>"> 
                                <a href="<?php echo e($item->getJourneyUrl()); ?>" class=""><?php echo e($item->name); ?> </a>
                            </h4>
                                
                            
                        </div>
                    </div>
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Loại tuyến</div>
                        <div class="no-overflow">
                            <span><?php echo e($types[$item->type]); ?></span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Bến đầu tuyến</div>
                        <div class="no-overflow">
                            <div><?php echo e($item->start_station); ?></div>
                            <div>(<?php echo e($item->from_province); ?>)</div>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Bến cuối tuyến</div>
                        <div class="no-overflow">
                            <div><?php echo e($item->end_station); ?></div>
                            <div>(<?php echo e($item->to_province); ?>)</div>

                        </div>
                    </div>
                
                    <div class="item-col item-col-same no-overflow item-col-stats">
                        <div class="item-heading">Lộ trình</div>
                        <div class="no-overflow">
                            <span>
                                <?php echo e($item->start_station); ?>

                                <i class="fa fa-long-arrow-right"></i>    
                                <?php $places = $item->places; ?>
                                <?php if(count($places)): ?>
                                    <?php $__currentLoopData = $places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($place->place_name); ?> 
                                        <i class="fa fa-long-arrow-right"></i>    

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                
                                <?php echo e($item->end_station); ?>

                            </span>
                            <span class="pl-2">
                                <a href="<?php echo e($item->getJourneyUrl()); ?>" class=""> <i class="fa fa-pencil-square-o"></i> </a>
                            </span>
                        </div>
                    </div>
                
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Chiều dài tuyến</div>
                        <div class="no-overflow">
                            <span>
                                <?php if($item->type!='bus'): ?>
                                <?php echo e($item->distance); ?> km
                                <?php else: ?>
                                    ...
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Quy hoạch tuyến</div>
                        <div class="no-overflow">
                            <span><?php echo e($item->month_trips); ?></span>
                        </div>
                    </div>
                
                        
                    <div class="item-col fixed item-col-stats pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-right">
                                <li>
                                    <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-item" data-id="<?php echo e($item->id); ?>" title="xóa">
                                        <i class="fa fa-trash"></i>
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
                <div class="col-12 col-md-4">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-8">
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
                delete_url: '<?php echo e(route('admin.route.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('is'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>