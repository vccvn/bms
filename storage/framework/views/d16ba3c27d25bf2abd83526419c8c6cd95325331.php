<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>



<?php $__env->startSection('title', 'Menu'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Menu
                        <a href="<?php echo e(route('admin.menu.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        <?php echo $__env->make($__templates.'list-search',['search_route'=>'admin.menu.list'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm menu </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="<?php echo e(route('admin.menu.save')); ?>"  novalidate="true">
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

        </div>
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            
            <!-- list content -->
            <?php if($list->count()>0): ?>
            <div class="card items">
                
                <ul class="item-list striped list-body list-menu">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="area-check">
                                    <input type="checkbox" class="checkbox check-all">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col item-col-header item-col-title item-col-same">
                                <div>
                                    <span>Tên</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Loại</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Menu chính</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Thứ tự</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-same-sm fixed item-col-actions-dropdown"> </div>
                        </div>
                    </li>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="item" id="menu-<?php echo e($item->id); ?>">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="menus[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed pull-left item-col-title item-col-same">
                                <div class="item-heading">Tên</div>
                                <div>
                                    <a href="<?php echo e($item->type=='default'?$item->getDetailUrl():$item->getUpdateUrl()); ?>" class="">
                                        <h4 class="item-title"> <?php echo e($item->name); ?> </h4>
                                    </a>
                                </div>
                            </div>
                            <div class="item-col item-col-stats no-overflow">
                                <div class="item-heading">Loại</div>
                                <div class="no-overflow">
                                    <?php echo e($item->type); ?>

                                </div>
                            </div>
                            <div class="item-col item-col-stats no-overflow">
                                <div class="item-heading">Loại</div>
                                <div class="no-overflow">
                                    <?php echo e($item->active?"Có":"Không"); ?>

                                </div>
                            </div>
                            <div class="item-col item-col-stats">
                                <div class="item-heading">Thứ tự</div>
                                <div>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo e($item->priority); ?>

                                        </button>
                                        <?php echo (new Cube\Html\Menu([
                                                    'type'=>'list',
                                                    'data'=>$item->getPriorityMenuList()
                                                ],[
                                                    'menu_id' => 'dropdown-item-'.$item->id,
                                                    'menu_class' => 'dropdown-menu',
                                                    'menu_tag' => 'div',
                                                    'item_tag' => null,
                                                    'link_class' => 'dropdown-item nav-link pt-2 pb-2'
                                                ],
                                                'action-'.$item->id
                                                )
                                            )->render(function($curent){
                                                $curent->link->href='#';
                                                if($curent->isLast()){
                                                    $curent->link->before('<div class="dropdown-divider"></div>');
                                                }
                                            }); ?>

                                        
                                    </div>
                                </div>
                            </div>
                            <div class="item-col fixed item-col-actions-dropdown item-col-same-sm">
                                <div class="item-actions">
                                    <ul class="actions-list">
                                        <li>
                                            <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="remove btn-delete-menu" data-id="<?php echo e($item->id); ?>">
                                                <i class="fa fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                
            </div>
            <div class="row pt-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-menu"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        <?php echo e($list->links('vendor.pagination.custom')); ?>

                    </nav>
                </div>
            </div>
            <?php else: ?>
                <p class="alert alert-danger text-center">
                    Danh sách trống
                </p>
            <?php endif; ?>

        </div>
    </div>
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.menusInit = function() {
        Cube.menus.init({
            urls:{
                delete_menu_url: '<?php echo e(route('admin.menu.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>