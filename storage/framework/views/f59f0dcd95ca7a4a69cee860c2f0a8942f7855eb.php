<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;
$fmact = isset($form_action)?route($form_action):'';
?>



<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> 
                        <?php echo e($title); ?>

                        
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    <!-- <?php echo e($errors->first()); ?> -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> <?php echo e(isset($form_title)?$form_title:$title); ?> </h3>
            </div>
            <form id="<?php echo e($form_id); ?>" method="POST" action="<?php echo e($fmact); ?>" enctype="multipart/form-data"  novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $form->id)); ?>">
                <input type="hidden" name="route_trips" value="<?php echo e(rand(1, 100)); ?>">
                <?php $__currentLoopData = $inputs->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                    if(!$input || in_array($input->name, ['freq_trips','weight'])) continue;
                    if(in_array($input->type,['radio','checkbox','checklist', 'cubeselect'])){
                        $input->removeClass('form-control');
                    }
                    $name = $input->name;
                    $t = $input->type;

                    ?>
                    <?php if($t=='hidden'): ?>
                        <?php echo $input; ?>

                        <!-- <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?> -->


                    <?php elseif($name=='freq_days'): ?>
                        <div class="row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                            <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>">Tần suất</label>
                            <div class="input-<?php echo e($t); ?>-wrapper col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <?php echo $input; ?>

                                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                </div>
                            </div>
                            <?php $input = $inputs->freq_trips; ?>
                            <div class="input-<?php echo e($t); ?>-wrapper col-sm-4 col-md-5 col-lg-4 col-xl-5">
                                <div class="form-group">
                                    <?php echo $input; ?>

                                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                </div>
                            </div>
                        </div>
                        <?php if($errors->has('route_trips')): ?>
                            <div class="form-group row has-error">
                                <div class="col-sm-8 col-md-9 col-lg-8 col-xl-9 ml-auto">
                                    <span class="has-error">
                                        <?php echo e($errors->first('route_trips')); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php elseif($name=='seets'): ?>
                    <div class="row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                        <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                        <div class="input-<?php echo e($t); ?>-wrapper col-sm-8 col-md-3 col-lg-2 col-xl-3">
                            <div class="form-group">
                                <?php echo $input; ?>

                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            </div>
                        </div>
                        <?php $input = $inputs->weight; ?>
                        <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                        <div class="input-<?php echo e($t); ?>-wrapper col-sm-8 col-md-3 col-lg-2 col-xl-3">
                            <div class="form-group">
                                <?php echo $input; ?>

                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="form-group row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                            
                            <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                            <div class="input-<?php echo e($t); ?>-wrapper col-sm-8 col-md-9 col-lg-8 col-xl-9">
                                <?php if($t=='image'): ?>
                                    <div class="input-group">
                                        <input class="input-file-fake form-control" readonly="true" type="text" name="<?php echo e($input->name); ?>_show" value="<?php echo e($input->val()); ?>">
                                        <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                    </div>
                                <?php else: ?>
                                    <?php echo $input; ?>

                                <?php endif; ?>
                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <div class="col-sm-4 col-lg-3"></div>
                    <div class="col-sm-8 col-lg-9">
                        <button class="btn btn-primary" type="submit"><?php echo e($btnSaveText); ?></button> 
                        <button class="btn btn-danger btn-cancel" type="button">Hủy</button>
                    </div>
                    
                </div>
                
            </form>
            
                
        </div>
    </div>


</article>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <style>
    label.required::after{
        content:"*";
        display: inline-block;
        color: #f00;
        margin-left: 5px;
        font-size: 1rem;
        line-height: 1.5;
    }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
<script>
    window.busInit = function() {
        Cube.bus.init({
            urls:{
                get_freq_trips_url: '<?php echo e(route('admin.bus.trip-option')); ?>',
                get_route_options_url: '<?php echo e(route('admin.route.option')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php echo $__env->make($__templates.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="<?php echo e(asset('js/admin/bus.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>