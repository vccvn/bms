<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>



<?php $__env->startSection('title', "Slider"); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Slider 
                        <a href="<?php echo e(route('admin.slider.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        <?php echo $__env->make($__templates.'list-search',['search_route'=>'admin.slider.list'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <!-- list content -->
    <div class="row">
        <div class="col-12 col-md-8 col-lg-12 col-xl-8">
            <?php if(count($list)>0): ?>
            <div class="card items">
                
                <ul class="item-list striped list-body list-slider">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="area-check">
                                    <input type="checkbox" class="checkbox check-all">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed item-col-check">
                                <span>ID</span>
                            </div>
                            <div class="item-col item-col-header item-col-same item-col-title">
                                <div>
                                    <span>Tên slider</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-same item-col-stats">
                                <div class="no-overflow">
                                    <span>Vị trí</span>
                                </div>
                            </div>

                            <div class="item-col item-col-header item-col-same item-col-stats">
                                <div class="no-overflow">
                                    <span>Kích thước</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-roles item-col-stats">
                                <div class="no-overflow">
                                    <span>Số slide</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-roles item-col-stats">
                                <div class="no-overflow">
                                    <span>Ưu tiên</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header fixed item-col-same-md ">
                                <div class="text-center">Actions</div>
                            </div>
                        </div>
                    </li>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="item" id="slider-<?php echo e($item->id); ?>">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="sliders[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed item-col-check">
                                <span><?php echo e($item->id); ?></span>
                            </div>
                            <div class="item-col fixed pull-left item-col-same item-col-title">
                                <div class="item-heading">Tên slider</div>
                                <div>
                                    <h4 class="item-title"> <a href="<?php echo e($item->getDetailUrl()); ?>" id="slider-name-<?php echo e($item->id); ?>"><?php echo e($item->name); ?></a> </h4>
                                </div>
                            </div>
                            <div class="item-col item-col-same item-col-stats no-overflow">
                                <div class="item-heading">Vị trí</div>
                                <div class="no-overflow">
                                    <?php echo e($item->getPosition()); ?>

                                </div>
                            </div>
                            <div class="item-col item-col-same item-col-stats no-overflow">
                                <div class="item-heading">Kích thước</div>
                                <div class="no-overflow ">
                                    <?php if($item->crop): ?>
                                        <?php echo e($item->width); ?> x <?php echo e($item->height); ?>

                                    <?php else: ?>
                                        Auto
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="item-col item-col-same item-col-stats no-overflow">
                                <div class="item-heading">Sớ slide</div>
                                <div class="no-overflow ">
                                    <?php echo e($item->items->count()); ?>

                                </div>
                            </div>
                            <div class="item-col item-col-roles item-col-stats">
                                <div class="item-heading">Ưu tiên</div>
                                <div>

                                    <div class="btn-group slider-priority-select">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo e($item->priority); ?>

                                        </button>
                                        <?php echo (new Cube\Html\Menu([
                                                    'type'=>'list',
                                                    'data'=>$item->getPriorityMenuList()
                                                ],[
                                                    'id' => 'dropdown-item-'.$item->id,
                                                    'class' => 'dropdown-menu priority-select',
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
                            <div class="item-col fixed item-col-sam-md item-col-stats">
                                <div class="item-actions">
                                    <ul class="actions-list">
                                        <li>
                                            <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit btn btn-sm btn-primary">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="remove btn-delete-slider btn btn-sm btn-danger" data-id="<?php echo e($item->id); ?>">
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
            <div class="row pt-2 pb-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-slider"><i class="fa fa-trash"></i></a>
                    
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
        <div class="col-12 col-md-4 col-lg-12 col-xl-4">
            <div class="card">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Thêm Slider </h3>
                    </div>
                    <form id="slider-form" method="POST" action="<?php echo e(route('admin.slider.save')); ?>"  novalidate="true">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $form->id)); ?>">
                       
                        <?php $inp = $inputs->name; ?>
                        <div class="form-group <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                            <label for="<?php echo e($inp->id); ?>" class="form-control-label" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                            <div class="input-<?php echo e($inp->type); ?>-wrapper">
                                <?php echo $inp; ?>


                                <?php echo $inp->error?(HTML::span($ninp->error,['class'=>'has-error'])):''; ?>


                            </div>
                        </div>

                        <?php $inp = $inputs->position; ?>
                        <div class="form-group <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                            <label for="<?php echo e($inp->id); ?>" class="form-control-label" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                            <div class="input-<?php echo e($inp->type); ?>-wrapper">
                                <?php echo $inp; ?>


                                <?php echo $inp->error?(HTML::span($ninp->error,['class'=>'has-error'])):''; ?>


                            </div>
                        </div>


                        <?php $inp = $inputs->crop->removeClass('form-control'); ?>
                        <div class="form-group row <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                            <div class="input-<?php echo e($inp->type); ?>-wrapper col-12">
                                <?php echo $inp; ?>


                                <?php echo $inp->error?(HTML::span($ninp->error,['class'=>'has-error'])):''; ?>


                            </div>
                        </div>

                        <?php 
                        $inw = $inputs->width;
                        $inh = $inputs->height; 
                        ?>
                        
                        <div class="form-group row <?php echo e(($inw->error||$inh->error)?'has-error':''); ?> d-none" id="form-group-size">
                            <label for="<?php echo e($inw->id); ?>" class="form-control-label  col-4 col-sm-4 col-md-12 col-lg-3 col-xl-12" id="label-for-<?php echo e($inw->name); ?>">Kích thức</label>
                            <div class="input-<?php echo e($inw->type); ?>-wrapper col-4 col-sm-4 col-md-6 col-lg-3 col-xl-6">
                                <?php echo $inw; ?>


                            </div>
                            <div class="input-<?php echo e($inh->type); ?>-wrappe col-4 col-sm-4 col-md-6 col-lg-3 col-xl-6">
                                <?php echo $inh; ?>


                            </div>
                            <div class="col-12">
                                <?php echo ($inw->error||$inh->error)?(HTML::span($inw->error?$inw->error:$inh->error,['class'=>'has-error'])):''; ?>


                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Thêm</button>
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
    window.slidersInit = function() {
        Cube.sliders.init({
            urls:{
                delete_url: '<?php echo e(route('admin.slider.delete')); ?>',
                change_priority_url:  '<?php echo e(route('admin.slider.change-priority')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>