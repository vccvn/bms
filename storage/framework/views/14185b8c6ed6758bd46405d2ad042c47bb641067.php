<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:$siteinfo->title;
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
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
            <form id="dynamic-form" method="POST" action="<?php echo e($fmact); ?>" enctype="multipart/form-data" novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $model->id)); ?>">

                <div class="input-group-hidden" style="display: none">
                    <?php if($model->gallery): ?>
                        <?php $__currentLoopData = $model->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="gallery_list[]" id="gallery-hidden-<?php echo e($ga->id); ?>" class="input-gallery-hidden" value="<?php echo e($ga->id); ?>" />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if($model->productLinks): ?>
                        <?php $__currentLoopData = $model->productLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="products[]" id="product-hidden-<?php echo e($link->product_id); ?>" class="input-product-hidden" value="<?php echo e($link->product_id); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <?php if($props = $post->getChildrenPropInputData()): ?>
                        <?php echo $__env->make($__current.'props', compact('props', 'inputs', 'required_fields'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php else: ?>
                        <?php echo $__env->make($__current.'non-props',compact('inputs', 'required_fields'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-5">
                        <?php if(in_array('feature_image', $required_fields)): ?>
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
                            <label for="keep_original" class="form-control-label ">
                                <input type="checkbox" name="keep_original" id="keep_original" <?php echo e(old('keep_original', $model->keep_original)?"checked":''); ?>> Giữ nguyên kích thước
                            </label>
                        </div>
                        <div class="form-group keep-original">
                            <?php echo $inputs->show_thumbnail->removeClass('form-control'); ?>

                        </div>
                        <?php endif; ?>
                        <?php $__currentLoopData = ['cate_id','keywords']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input || !in_array($input->name, $required_fields)) continue;
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
                        <?php 

                        $tag_templates = [
                            'list' => '<ul class="taglist">{$items}</ul>',
                            'item' => '<li class="tagitem" id="tag-item-{$id}"><a href="#" class="add-tag-item" data-id="{$id}" data-keywords="{$keywords}">{$keywords}</a></li>',
                            'hidden_input' => '<input type="hidden" name="tags[]" id="tag-hidden-{$id}" class="input-tag-hidden" value="{$id}">',
                            'link_item' => '<li id="taglink-item-{$id}" class="taglink-item">{$keywords} <a href="#" class="btn-remove-taglink" data-id="{$id}">x</a></li>',
                            'link_list' => '<ul class="tag-list-body">{$items}</ul>'
                        ];
                        $t = in_array('tag',$required_fields);
                        $hasProductLink = in_array('product_link',$required_fields);
                        if($hasProductLink){
                            $templates = [
                                // link-item search
                                'product_item' => '
                                    <div class="produvt-link-item" id="product-link-{$id}">
                                        {$name} 
                                        <a href="javascript:void(0)" class="btn-delete-product-item" data-id="{$id}">x</a>
                                    </div>',
                                
                                'product_list' => '
                                    <div class="produvt-link-list">{$items}</div>
                                ',
                                
                                'search_result' => '
                                    <div class="product-search-item" id="search-result-item-{$id}">
                                        <div class="check-block">
                                            <label class="item-block">
                                                <input type="checkbox" name="product[]" class="check-item checkbox" data-id="{$id}" value="{$id}">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="product-detail-block">
                                            <h5 class="product-name">{$name}</h5>
                                        </div>
                                        <div class="btn-block">
                                            <button type="button" class="btn btn-sm btn-primary btn-add-product-link" data-id="{$id}">Thêm</button>
                                        </div>
                                    </div>
                                ',
                                'search_list' => '
                                    <div class="search-result-list">
                                        <div class="product-search-item row-header">
                                            <div class="check-block">
                                                <label class="item-block">
                                                    <input type="checkbox" name="checkall" class="check-all checkbox" data-id="{$id}" value="{$id}">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="product-detail-block">
                                                <h5 class="title">Tên sãn phẩm</h5>
                                            </div>
                                            <div class="btn-block">
                                                <button type="button" class="btn btn-sm btn-warning btn-add-all-product-link">Thêm</button>
                                            </div>
                                        </div>
                                        <div class="list-body">
                                            {$results}
                                        </div>
                                        <div class="product-search-item row-footer">
                                            <div class="check-block">
                                                
                                            </div>
                                            <div class="product-detail-block">
                                                <p>{$total} sản phẩm</p>
                                            </div>
                                            <div class="btn-block">
                                                <button type="button" class="btn btn-sm btn-warning btn-add-all-product-link">Thêm</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                ',
                                
                                // linked
                                'linked_item' => '
                                    <div class="product-search-item" id="product-linked-item-{$id}">
                                        <div class="check-block">
                                            <label class="item-block">
                                                <input type="checkbox" name="product[]" class="check-item checkbox" data-id="{$id}" value="{$id}">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="product-detail-block">
                                            <h5>{$name}</h5>
                                        </div>
                                        <div class="btn-block">
                                            <button type="button" class="btn btn-sm btn-warning btn-delete-product-link" data-id="{$id}">Xóa</button>
                                        </div>
                                    </div>
                                ',
                                'linked_list' => '
                                    <div class="product-linked-list">
                                        <div class="product-search-item row-header">
                                            <div class="check-block">
                                                <label class="item-block">
                                                    <input type="checkbox" name="checkall" class="check-all checkbox" data-id="{$id}" value="{$id}">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="product-detail-block">
                                                <h5 class="title">Tên sãn phẩm</h5>
                                            </div>
                                            <div class="btn-block">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-all-product-link">Xóa</button>
                                            </div>
                                        </div>
                                        <div class="list-body">
                                            {$links}
                                        </div>
                                        <div class="product-search-item row-footer">
                                            <div class="check-block">
                                                
                                            </div>
                                            <div class="product-detail-block">
                                                <p><span class="total-product">{$total}</span> sản phẩm</p>
                                            </div>
                                            <div class="btn-block">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-all-product-link">Xóa</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                ',
                                
                                'message' => '
                                    <div class="search-message text-center">{$message}</div>
                                ',
                                'hidden_product_input' => '<input type="hidden" name="products[]" id="product-hidden-{$id}" class="input-product-hidden" value="{$id}">'
                            ];
                        }
                        ?>
                        <?php echo $__env->make($__current.'advance', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        
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
    <?php if(in_array('slug', $required_fields)): ?>
    window.slugsInit = function() {
        Cube.slugs.init({
            input_selector:"input#title",
            urls:{
                get: '<?php echo e(route('admin.dynamic.get-slug')); ?>',
                check: '<?php echo e(route('admin.dynamic.check-slug')); ?>'
            }
        });
    };
    <?php endif; ?>
    <?php if(in_array('tag', $required_fields)): ?>
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
    <?php endif; ?>

    <?php if($hasProductLink): ?>
    <?php
    $templates = json_encode($templates);
    ?>
    window.postsInit = function() {
        Cube.posts.init({
            urls:{
                search_product_url: '<?php echo e(route('admin.post.product-links-data')); ?>'
            },
            templates: <?php echo $templates; ?>

        });
    };
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <?php if(in_array('tag', $required_fields)): ?>
        <script src="<?php echo e(asset('js/admin/tags.js')); ?>"></script>
    <?php endif; ?>
    <?php if(in_array('feature_image', $required_fields)): ?>
        <script src="<?php echo e(asset('js/admin/image-editor.js')); ?>"></script>
    <?php endif; ?>
    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php if(in_array('feature_image', $required_fields)): ?>
    <script>
        startImageEditor("#dynamic-form", "<?php echo e(asset('contents/dynamics/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))); ?>");
    </script>
    <?php endif; ?>
    <?php if($post->post_type=='gallery'): ?>
    <script type="text/javascript">
        Cube.uploader.addForm('#dynamic-form', 'gallery_images[]');
    </script>
    <?php endif; ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>