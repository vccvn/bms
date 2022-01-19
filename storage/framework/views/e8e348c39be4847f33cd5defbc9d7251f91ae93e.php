<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:"cubeAdmin";
$fd = isset($formdata)?$formdata:null;
$fmact = isset($form_action)?$form_action:'';
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>



<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> <?php echo e(isset($form_title)?$form_title:$title); ?>

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
            <form id="category-form" method="POST" action="<?php echo e($fmact); ?>" enctype="multipart/form-data" novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $model->id)); ?>">
                
                <div class="input-group-hidden" style="display: none">
                    
                    
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <h4 class="text-center">Chi tiết</h4>
                        <?php $__currentLoopData = ['name', 'parent_id','description']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            ?>
                            <div class="form-group <?php echo e($input->error?'has-error':''); ?> " id="form-group-<?php echo e($input->name); ?>">
                                <label for="<?php echo e($input->id); ?>" class="form-control-label " id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                                <div class="input-<?php echo e($input->type); ?>-wrapper">
                                    <?php echo $input; ?>

                                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        

                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <h4 class="text-center">Hình minh họa</h4>
                            <div class="select-file image-editor">
                                <div class="cropit-preview"></div>
                                
                                <input type="hidden" name="image_data" class="hidden-image-data" />
                                <div class="change-icon-wrapper">
                                    <div class="file-select">
                                        <div class="choose-icon">
                                            <i class="fa fa-camera"></i> Chọn ảnh
                                        </div>
                                        <input type="file" name="feature_image" class="cropit-image-input" id="feature_image" accept="image/jpeg,image/png,image/gif">
                                    </div>
                                </div>
                            </div>
                            <div class="message text-danger text-center">
                                <?php echo $inputs->feature_image->error?(HTML::span($inputs->feature_image->error,['class'=>'has-error'])):''; ?>

                            </div>
                            
                        </div>
                        <?php $__currentLoopData = ['keywords', 'is_menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            ?>
                            <div class="form-group <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($input->name); ?>">
                                <?php if($input->type!='checkbox'): ?>
                                <label for="<?php echo e($input->id); ?>" class="form-control-label" id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                                <?php endif; ?>
                                <div class="input-<?php echo e($input->type); ?>-wrapper">
                                    <?php echo $input; ?>

                                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                </div>
                            </div>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit"><?php echo e($btnSaveText); ?></button> 
                            <button class="btn btn-danger" type="button">Hủy</button>
                        </div>
                    </div>
                </div>
                <div class="row"></div>
            </form>
        </div>
    </div>
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/image-editor.css')); ?>" />
    <style>
    .image-editor, .keep-original  {
        width: 400px;
        margin: 0 auto;
        position: relative;
    }

    .cropit-preview {
        /* You can specify preview size in CSS */
        width: 400px;
        height: 300px;
    }


    </style>
<?php $__env->stopSection(); ?>
<?php 
$template = '
    <div id="prop-{$index}" class="row cate-props">
        <div class="col-sm-6 col-md-3 col-prop-name">
            <input type="text" name="props[{$index}][name]" id="prop-{$index}-name" class="form-control" placeholder="Tên. vd: color">
        </div>
        <div class="col-sm-6 col-md-3 col-prop-label">
            <input type="text" name="props[{$index}][label]" id="prop-{$index}-label" class="form-control" placeholder="Nhãn. vd: màu sắc">
        </div>
        <div class="col-sm-6 col-md-3 col-prop-type">
            <select name="props[{$index}][type]" id="prop-{$index}-type" class="form-control">
                <option value="text">text</option>
                <option value="number">Số</option>
                <option value="list">Danh sách</option>
                
            </select>
        </div>
        <div class="col-sm-6 col-md-3 col-prop-default">
            <input type="text" name="props[{$index}][defval]" id="prop-{$index}-defval" class="form-control" placeholder="ví dụ a, b">
        </div>
    </div>
';
?>
<?php $__env->startSection('jsinit'); ?>
<script>
    
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/admin/tags.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/image-editor.js')); ?>"></script>

    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script>
        startImageEditor("#category-form", "<?php echo e(asset('contents/categories/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))); ?>");
    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>