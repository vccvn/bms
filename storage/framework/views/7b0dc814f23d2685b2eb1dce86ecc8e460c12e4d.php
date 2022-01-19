<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$types = ['province' => 'Tỉnh','city' => 'Thành Phố'];
?>




<?php $__env->startSection('title', 'Tỉnh thành'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Bến xe đầu cuối
                        <a href="<?php echo e(route('admin.station.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
    <div class="row">
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <div class="card items">
                <?php echo $__env->make('admin._templates.list-filter',[
                    'filter_list'=>[
                        'name' => 'Tên bến xe',
                        'province_name' => 'Tên tỉnh thành'
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
                            <div class="item-col fixed item-col-check">
                                <span>Mã</span>
                            </div>
                            <div class="item-col item-col-header item-col-same-md item-col-title">
                                <div>
                                    <span>Tên bến xe</span>
                                </div>
                            </div>
                            
                            <div class="item-col item-col-header item-col-same-sm">
                                <div>
                                    <span>Tỉnh thành</span>
                                </div>
                            </div>
                            
                            <div class="item-col item-col-header item-col-same">
                                <div>
                                    <span>Địa chỉ</span>
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
                            <div class="item-col fixed item-col-check">
                                <span><?php echo e($item->id); ?></span>
                            </div>
                            <div class="item-col fixed pull-left item-col-title item-col-same-md">
                                <div class="item-heading">Tên bến xe</div>
                                <div>
                                    
                                    <h4 class="item-title" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>"> 
                                        <a href="<?php echo e($item->getUpdateUrl()); ?>" class=""><?php echo e($item->name); ?> </a>
                                    </h4>
                                        
                                    
                                </div>
                            </div>
                            
                            <div class="item-col item-col-same-sm no-overflow">
                                <div class="item-heading">Tỉnh thành</div>
                                <div class="no-overflow">
                                    <span><?php echo e($item->province_name); ?></span>
                                </div>
                            </div>
                        
                            <div class="item-col item-col-same no-overflow">
                                <div class="item-heading">Địa chỉ</div>
                                <div class="no-overflow">
                                    <span><?php echo e($item->address); ?></span>
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
        </div>

        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm Bến xe </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="<?php echo e(route('admin.station.save')); ?>"  novalidate="true">
                        <?php echo csrf_field(); ?>
        
                        <?php $__currentLoopData = $inputs->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                            <?php if(!in_array($inp->type,['radio','checkbox','checklist'])): ?>
                            <label for="<?php echo e($inp->id); ?>" class="form-control-label" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                            <?php else: ?>
                            <?php $inp->removeClass('form-control'); ?>
                            <?php endif; ?>
                            <div class="input-<?php echo e($inp->type); ?>-wrapper">
                                <?php echo $inp; ?>

        
                                <?php echo $inp->error?(HTML::span($ninp->error,['class'=>'has-error'])):''; ?>

        
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Thêm</button>
                        </div>
                    </form>        
                </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Nhập dữ liệu bến xe </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="<?php echo e(route('admin.station.import')); ?>" enctype="multipart/form-data"  novalidate="true">
                        <?php echo csrf_field(); ?>
                        <div class="form-group form-input-file-group">
                            <div class="input-file-wrapper">
                                <div class="input-group">
                                    <input class="input-file-fake form-control" readonly="true" type="text" name="file_data_show" value="<?php echo e(old('file_data')); ?>" placeholder="Chọn file">
                                    <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                </div>
                                <input type="file" name="file_data" id="file_data" class="input-hidden-file" accept=".json">
                                <?php if($errors->has('file_data')): ?>
                                    <span class="has-erroe"><?php echo e($errors->first('file_data')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

        
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Nhập</button>
                        </div>
                    </form>        
                </div>
            </div>

        </div>
    </div>
    
    
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.station.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('is'); ?>
<?php if(session('added')): ?>
<script>
    modal_alert('<?php echo e(session('added')); ?>');
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>