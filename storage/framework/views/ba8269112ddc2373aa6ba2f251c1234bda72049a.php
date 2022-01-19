<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:$siteinfo->title;
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
$form = new FormData($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):(isset($form_url)?$form_url:'');
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
            <div class="title-block">
                <h3 class="title">  </h3>
            </div>
            <form id="page-form" method="POST" action="<?php echo e($fmact); ?>" enctype="multipart/form-data" novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $model->id)); ?>">

                <div class="input-group-hidden" style="display: none">
                    
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="text-center">Thông tin <?php echo e(isset($page)?'chi tiết':"trang"); ?></h3>
                        <?php $__currentLoopData = ['title','slug','description','content']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            ?>
                            <?php if($name=='slug'): ?>
                                <?php if(!$inputs->custom_slug->val())$input->attr('readonly',"true");?>
                                <div class="form-group <?php echo e($input->error?'has-error':''); ?> " id="form-group-<?php echo e($input->name); ?>">
                                    <label for="<?php echo e($input->id); ?>" class="form-control-label " id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                                    <div class="input-<?php echo e($input->type); ?>-wrapper">
                                        <div class="input-group input-slug">
                                            <div class="input-group-prepend input-group-addon">
                                                <label class="input-group-text mb-0" id="label-for-<?php echo e($input->name); ?>">
                                                    <input type="checkbox" name="custom_slug" id="custom_slug" class="checkbox" <?php echo e($inputs->custom_slug->val()?"checked=\"true\"":""); ?>>
                                                    <span>Tùy chỉnh</span>
                                                </label>
                                            </div>
                                            <?php echo $input; ?>

                                            <div class="input-group-append input-group-addon"><span>.html</span></div>
                                        </div>
                                        <?php echo HTML::span($input->error,['class'=>'slug-message has-error slug-message']); ?>

                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="form-group <?php echo e($name=='type'?"dev-only":""); ?> <?php echo e($input->error?'has-error':''); ?> " id="form-group-<?php echo e($input->name); ?>">
                                    <label for="<?php echo e($input->id); ?>" class="form-control-label " id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                                    <div class="input-<?php echo e($input->type); ?>-wrapper">
                                        <?php echo $input; ?>

                                        <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="col-md-5">
                        <h3 class="text-center">Hình minh họa</h3>
                        <div class="select-file image-editor">
                            <div class="cropit-preview"></div>
                            <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" />
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
                        <div class="form-group keep-original">
                            <label for="keep_original" class="form-control-label "><input type="checkbox" name="keep_original" id="keep_original" <?php echo e(old('keep_original', $model->keep_original)?"checked":''); ?>> Giữ nguyên kích thước</label>
                        </div>
                        <div class="form-group keep-original">
                            <?php echo $inputs->show_thumbnail->removeClass('form-control'); ?>

                        </div>
                        
                        <?php $__currentLoopData = ['parent_id','keywords']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            ?>
                        

                        <div class="form-group <?php echo e($input->error?'has-error':''); ?> " id="form-group-<?php echo e($input->name); ?>">
                            <?php if($input->type!='checkbox'): ?>
                                <label for="<?php echo e($input->id); ?>" class="form-control-label" id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                            <?php endif; ?>
                            <div class="input-<?php echo e($input->type); ?>-wrapper">
                                <?php echo $input; ?>

                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        <!-- link -->
                        <div class="card sameheight-item">

                            <?php 
                            $tag_templates = [
                                'list' => '<ul class="taglist">{$items}</ul>',
                                'item' => '<li class="tagitem" id="tag-item-{$id}"><a href="#" class="add-tag-item" data-id="{$id}" data-keywords="{$keywords}">{$keywords}</a></li>',
                                'hidden_input' => '<input type="hidden" name="tags[]" id="tag-hidden-{$id}" class="input-tag-hidden" value="{$id}">',
                                'link_item' => '<li id="taglink-item-{$id}" class="taglink-item">{$keywords} <a href="#" class="btn-remove-taglink" data-id="{$id}">x</a></li>',
                                'link_list' => '<ul class="tag-list-body">{$items}</ul>'
                            ];
                            ?>
                            <div class="product-links">
                                <!-- Nav tabs -->
                                <div class="card-title-block">
                                    <h3 class="title"> Mở rộng </h3>
                                </div>
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <a href="#tag-link" class="nav-link active" data-target="#tag-link" data-toggle="tab" aria-controls="product-linked" role="tab">Thẻ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#advanced-feature" class="nav-link" data-target="#advanced-feature" data-toggle="tab" aria-controls="product-linked" role="tab">Nâng cao</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-bordered">
                                    <div class="tab-pane fade in active show" id="tag-link">
                                        <h5>Thẻ</h5>
                                        <?php echo $__env->make($__templates.'add-tags-feature', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </div>
                                    <div class="tab-pane fade in" id="advanced-feature">
                                        <h5>Các tùy chọn nâng cao</h5>
                                        <?php $__currentLoopData = ['with_sidebar', 'layout', 'display_content']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-block -->
                        </div>
                        <!-- /.card -->
                        

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit"><?php echo e($btnSaveText); ?></button> 
                            <button class="btn btn-danger" type="button">Hủy</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                </div>

            </form>
            
                
        </div>
    </div>


</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/datetimepicker/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/image-editor.css')); ?>" />
    <style>
    .image-editor, .keep-original {
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

<?php $__env->startSection('jsinit'); ?>
<script>
    window.slugsInit = function() {
        Cube.slugs.init({
            input_selector:"input#title",
            urls:{
                get: '<?php echo e(route('admin.page.get-slug')); ?>',
                check: '<?php echo e(route('admin.page.check-slug')); ?>'
            }
        });
    };
    
    window.tagsInit = function() {
        Cube.tags.init({
            urls:{
                data_url: '<?php echo e(route('admin.content.tag.data')); ?>',
                get_tag_url: '<?php echo e(route('admin.content.tag.get')); ?>',
                add_tag_url: '<?php echo e(route('admin.content.tag.ajax-add')); ?>'
            },
            templates: <?php echo json_encode($tag_templates); ?>,
            search_selector:'#input-tag-link'
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/admin/tags.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/image-editor.js')); ?>"></script>
    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
</script>
<script>
    startImageEditor("#page-form", "<?php echo e(asset('contents/pages/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))); ?>");
    
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>