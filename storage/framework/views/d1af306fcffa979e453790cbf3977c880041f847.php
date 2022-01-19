<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$types = ['province' => 'Tỉnh','city' => 'Thành Phố'];
if($route->type == 'bus'){
    $inputs->province_id->type='hidden';
}
?>




<?php $__env->startSection('title', 'Tuyến đường: '.$route->name); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> 
                            <a href="javascript:window.history.back();" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-left"></i> </a>
                        <?php echo e($route->name); ?> 
                        
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
    <div class="row">
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <div class="card items">
                <div class="card-block">
                    <div class="title-block">
                        <h3 class="title"> Hành trình: <span class="pr-3">Bến xe <?php echo e($route->start_station . " ($route->from_province)"); ?></span> <i class="fa fa-exchange"></i> <span class="pl-3">Bến xe <?php echo e($route->end_station . " ($route->to_province)"); ?></span> </h3>
                    </div>
                    <div class="cf nestable-lists passing-list">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                <?php $__currentLoopData = $journeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
                                <li class="dd-item" data-id="<?php echo e($item->id); ?>" id="item-<?php echo e($item->id); ?>">
                                    <div class="item-actions">
                                        <a href="#" class="remove btn-delete-item" data-id="<?php echo e($item->id); ?>">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->place_name); ?>"><?php echo e($item->place_name); ?> (<?php echo e($item->province_name); ?>)</div>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>

        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm Địa điểm </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="add-passing-place-form" method="POST" action="<?php echo e(route('admin.place.add-passing-place')); ?>"  novalidate="true">
                        <?php $__currentLoopData = $inputs->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                            <?php if(!in_array($inp->type,['radio','checkbox','checklist', 'hidden'])): ?>
                            <label for="<?php echo e($inp->id); ?>" class="form-control-label" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                            <?php else: ?>
                            <?php $inp->removeClass('form-control'); ?>
                            <?php endif; ?>
                            <?php if($inp->type=='hidden'): ?>
                                <?php echo $inp; ?>

                            <?php else: ?>
                                <div class="input-<?php echo e($inp->type); ?>-wrapper">
                                        <?php echo $inp; ?>

            
                                    <?php echo $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):''; ?>

            
                                </div>    
                            <?php endif; ?>
                            
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
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


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/nestable2.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.place.delete-passing')); ?>'
            }
        });
    };

    window.journeyInit = function() {
        Cube.journey.init({
            urls:{
                get_places_url: '<?php echo e(route('admin.place.option')); ?>',
                sort_places_url: '<?php echo e(route('admin.place.sort-place')); ?>',
                
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <?php echo $__env->make($__templates.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('js/admin/jquery.nestable.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/journey.js')); ?>"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>