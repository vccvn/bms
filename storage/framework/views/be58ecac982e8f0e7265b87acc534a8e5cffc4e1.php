<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\Input;
?>
                        <h3 class="text-center">Thông tin <?php echo e(isset($post)?'chi tiết':"mục"); ?></h3>
                        <?php $__currentLoopData = ['title','slug','description','content']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            $input = $inputs->get($name);
                            if(!$input || !in_array($input->name, $required_fields)) continue;
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
                                <?php if($post->post_type=='gallery'): ?>
                                <div class="library mb-4">
                                        <h4 class="text-center">Thư viện ảnh</h4>
                                        <?php
                                            $input = $inputs->gallery_images;
                                            
                                        ?>
                                        <div class="form-group required <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($input->name); ?>">
                                            <div class="input-<?php echo e($input->type); ?>-wrapper">
                                                <?php
                                                    $input->name.='[]';
                                                ?>
                                                <?php echo $input; ?>

                                                <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                                <div class="uploader-preview-frame" style="display:<?php echo e(count($model->gallery)?'block':'none'); ?>;">
                                                    <h4>Xem trước</h4>
                                                    <div class="uploader-preview">
                                                        <?php if($model->gallery): ?>
                                                            <?php $__currentLoopData = $model->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div id="upload-item-<?php echo e($ga->id); ?>" class="upload-preview-item " title="<?php echo e($ga->original_filename); ?>">
                                                                <a class="btn-delete btn-delete-uploaded-item" href="#" data-id="<?php echo e($ga->id); ?>">X</a>
                                                                <img class="upload-preview-item-image" src="<?php echo e($ga->getUrl()); ?>">
                                                            </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
            
                                                        
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php elseif($post->post_type=='video'): ?>
                                    <?php
                                        $input = $inputs->video_url;
                                    ?>
                                    <div class="form-group <?php echo e($input->error?'has-error':''); ?> " id="form-group-<?php echo e($input->name); ?>">
                                        <label for="<?php echo e($input->id); ?>" class="form-control-label " id="label-for-<?php echo e($input->name); ?>"><?php echo e($input->label); ?></label>
                                        <div class="input-<?php echo e($input->type); ?>-wrapper">
                                            <?php echo $input; ?>

                                            <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
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
