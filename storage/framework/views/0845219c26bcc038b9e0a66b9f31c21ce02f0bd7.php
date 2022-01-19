<?php $__env->startSection('title', 'Liên hệ'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Liên hệ </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        <?php echo $__env->make('admin.contact.templates.list-filter',[
            'filter_list'=>[
                'name' => 'Họ tên',
                'email' => 'Email',
                'subject' => 'Tiêu đề',
                'created_at' => 'Thời gian'
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
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Tiêu đề</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div class="no-overflow">
                            <span>Ngưởi gửi</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Email</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Tóm tắt</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same-md item-col-stats"> </div>
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
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tiêu đề</div>
                        <div>
                            <a href="<?php echo e($item->getDetailUrl()); ?>" class="">
                                <h4 class="item-title" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->id); ?>"> <?php echo e($item->subject?$item->subject:$item->name . ' vừa gửi liên hệ'); ?> </h4>
                                
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same-sm no-overflow">
                        <div class="item-heading">Người gữi</div>
                        <div class="no-overflow">
                            <?php echo e($item->name); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Email</div>
                        <div class="no-overflow">
                            <?php echo e($item->email); ?>

                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Tóm tắt</div>
                        <div class="no-overflow">
                            <?php echo e($item->getShortDesc(100)); ?>

                        </div>
                    </div>
                    
                    <div class="item-col fixed item-col-stats item-col-same-md pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-right">
                                <li>
                                    <a href="<?php echo e($item->getDetailUrl()); ?>#replay" class="btn-replay" title="trả lời">
                                        <i class="fa fa-reply"></i>
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
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
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
                delete_url: '<?php echo e(route('admin.contact.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('plugins/moment-with-locales.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datetimepicker/bootstrap.js')); ?>"></script>
    <script type="text/javascript">
        $(function(){
            $('input.filter-date, #datepicker-from, #datepicker-to').datetimepicker({
                locale: 'vi',
                format: 'YYYY-MM-DD'
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo e(asset('plugins/datetimepicker/bootstrap.css')); ?>" />
<style>
    .filter-form .row>div{
        padding-top: 15px;
    }
    .filter-form .form-group{
        margin-bottom: 5px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>