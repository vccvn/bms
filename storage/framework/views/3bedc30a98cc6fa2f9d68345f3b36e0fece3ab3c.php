<?php
use Cube\Html\Inputs;
use Cube\Html\Input;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$fmact = isset($form_action)?route($form_action):'';
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>


    <input type="hidden" name="id" value="<?php echo e($model->id); ?>" class="item-inp">
    <?php if($group_inputs): ?>
        <?php $__currentLoopData = $group_inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if(is_array($inp)){
                    $input = new Input($inp);
                }else{
                    $input = $inputs->get($inp);
                }
                if(!$input) {
                        continue;
                    }
                if(!in_array($input->type,['radio','checkbox','checklist'])){
                    $input->addClass('form-control');
                }
                $input->id = 'menu-item-'.$input->id;
                if($input->name == 'icon'){
                    $input->addClass('input-icon');
                }
                $input->addClass('item-inp');
            ?>
            <?php if($input->type=='hidden'): ?>
            <?php echo $input; ?>

            <?php else: ?>
                <div class="form-group">
                    <?php if(!in_array($input->type,['radio','checkbox','checklist'])): ?>
                    <label for="<?php echo e('menu-item-'.$input->id); ?>" class="form-control-label"><?php echo e($input->label); ?></label>
                    <?php endif; ?>
                    <?php echo $input; ?>

                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    