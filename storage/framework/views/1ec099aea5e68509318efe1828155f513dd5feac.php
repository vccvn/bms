<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$siteinfo->title;
?>



<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> <?php echo e($title); ?>

                        <?php if(isset($back_link)): ?> 
                            <a href="<?php echo e($back_link); ?>" class="btm btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <?php endif; ?>
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> <?php echo e(isset($form_title)?$form_title:$title); ?> </h3>
            </div>
            <form id="slider-form" method="POST" action="<?php echo e(route('admin.slider.save')); ?>"  novalidate="true">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $form->id)); ?>">
                   
                    <?php $inp = $inputs->name; ?>
                    <div class="form-group row <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                        <label for="<?php echo e($inp->id); ?>" class="form-control-label col-sm-3 col-lg-2" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                        <div class="input-<?php echo e($inp->type); ?>-wrapper col-sm-8 col-lg-10">
                            <?php echo $inp; ?>

                            <?php echo $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):''; ?>

                        </div>
                    </div>

                    <?php $inp = $inputs->position; ?>
                    <div class="form-group row <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                        <label for="<?php echo e($inp->id); ?>" class="form-control-label  col-sm-3 col-lg-2" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                        <div class="input-<?php echo e($inp->type); ?>-wrapper col-sm-8 col-lg-10">
                            <?php echo $inp; ?>

                            <?php echo $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):''; ?>

                        </div>
                    </div>


                    <?php $inp = $inputs->crop->removeClass('form-control'); ?>
                    <div class="form-group row <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                        <label for="<?php echo e($inp->id); ?>" class="form-control-label  col-sm-3 col-lg-2" id="label-for-<?php echo e($inp->name); ?>"></label>
                        <div class="input-<?php echo e($inp->type); ?>-wrapper col-sm-9 col-lg-10">
                            <?php echo $inp; ?>

                            <?php echo $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):''; ?>

                        </div>
                    </div>

                    <?php 
                    $inw = $inputs->width;
                    $inh = $inputs->height; 
                    ?>
                    
                    <div class="form-group row <?php echo e(($inw->error||$inh->error)?'has-error':''); ?> d-none" id="form-group-size">
                        <label for="<?php echo e($inw->id); ?>" class="form-control-label col-5 col-sm-3 col-lg-2" id="label-for-<?php echo e($inw->name); ?>">Kích thức</label>
                        <div class="input-<?php echo e($inw->type); ?>-wrapper col-3 col-sm-3 col-lg-2">
                            <?php echo $inw; ?>

                            <?php echo $inw->error?(HTML::span($inw->error,['class'=>'has-error'])):''; ?>

                        </div>
                        <div class="input-<?php echo e($inh->type); ?>-wrappe col-2 col-sm-3 col-lg-2">
                            <?php echo $inh; ?>

                            <?php echo $inh->error?(HTML::span($inh->error,['class'=>'has-error'])):''; ?>

                        </div>
                    </div>

                    <?php if($inputs->priority): ?>
                    <?php $inp = $inputs->priority; ?>
                    <div class="form-group row <?php echo e($inp->error?'has-error':''); ?>" id="form-group-<?php echo e($inp->name); ?>">
                        <label for="<?php echo e($inp->id); ?>" class="form-control-label col-5 col-sm-3 col-lg-2" id="label-for-<?php echo e($inp->name); ?>"><?php echo e($inp->label); ?></label>
                        <div class="input-<?php echo e($inp->type); ?>-wrapper col-7 col-sm-8 col-lg-10">
                            <?php echo $inp; ?>

                            <?php echo $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):''; ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-3 col-lg-2"></div>
                        <div class="col-sm-9 col-lg-10">
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
    <link rel="stylesheet" href="<?php echo e(asset('plugins/datetimepicker/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-select/css/bootstrap-select.css')); ?>" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap-select/js/bootstrap-select.js')); ?>"></script>
    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>