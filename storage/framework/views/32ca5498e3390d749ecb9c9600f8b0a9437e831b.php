<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;
?>



<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> <a href="<?php echo e($slider->getDetailUrl()); ?>"><?php echo e($title); ?></a>
                        
                        <a href="<?php echo e($slider->getDetailUrl()); ?>" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        
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
            <form id="slider-item-form" method="POST" action="<?php echo e(route('admin.slider.item.save')); ?>" enctype="multipart/form-data"  novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $form->id)); ?>">
                <?php $__currentLoopData = $fieldList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                    $input = $inputs->get($name);
                    $t = $input->type;
                    ?>
                    <?php if($t=='hidden'): ?>
                        <?php echo $input; ?>

                        <!-- <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?> -->
                    <?php elseif($name!='image'): ?>
                    <div class="form-group row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                            <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-3 col-md-2 col-lg-3 col-xl-2" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                            <div class="input-<?php echo e($t); ?>-wrapper col-sm-9 col-md-10 col-lg-9 col-xl-10">
                                <?php echo $input; ?>

                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            </div>
                        </div>
                    <?php else: ?>
                    <div class="form-group form-input-<?php echo e($t); ?>-group row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                        <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-3 col-md-2 col-lg-3 col-xl-2" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                        <div class="input-<?php echo e($t); ?>-wrapper col-sm-9 col-md-10 col-lg-9 col-xl-10">
                            <?php if($slider->crop): ?>
                            <div class="select-file image-editor">
                                <div class="cropit-preview"></div>
                                <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" />
                                <input type="hidden" name="image_data" class="hidden-image-data" />
                                <div class="change-icon-wrapper">
                                    <div class="file-select">
                                        <div class="choose-icon">
                                            <i class="fa fa-camera"></i> Chọn ảnh
                                        </div>
                                        <input type="file" name="image" class="cropit-image-input" id="image" accept="image/jpeg,image/png,image/gif">
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="input-group">
                                    <input class="input-file-fake form-control" readonly="true" type="text" name="image_show" value="<?php echo e($input->val()); ?>">
                                    <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                </div>
                                
                                <?php echo $input->addClass('input-hidden-file'); ?>

                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php if($slider->crop): ?>
    
    <?php $__env->startSection('js'); ?>
        <script>
            $(function() {
                function saveImageData(){
                    var imageData = $('.image-editor').cropit('export');
                    $('.hidden-image-data').val(imageData);
                };
                $('.image-editor').cropit({ 
                    imageState: { 
                        src:  "<?php echo e(asset('contents/sliders/'.(($inputs->image && $inputs->image->val())?$inputs->image->value:'default.png'))); ?>"
                    },
                    smallImage:'allow',
                    onFileChange:function() {
                        setTimeout(saveImageData,100);
                    }
                });

                $('.cropit-image-zoom-input').change(function() {
                    setTimeout(saveImageData,100);
                });
                $('#slider-item-form').submit(function() {
                    saveImageData();
                    return true;
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/image-editor.css')); ?>" />
    <style>
    .image-editor {
        width: <?php echo e($slider->width); ?>px;
        margin: 0 auto;
        position: relative;
    }

    .cropit-preview {
        /* You can specify preview size in CSS */
        width: <?php echo e($slider->width); ?>px;
        height: <?php echo e($slider->height); ?>px;
    }


    </style>
    
    <?php $__env->stopSection(); ?>

<?php endif; ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>