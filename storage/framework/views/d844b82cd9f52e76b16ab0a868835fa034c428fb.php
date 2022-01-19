<?php
use Cube\Html\Inputs;
use Cube\Html\Input;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);

?>



<?php if(isset($form_list) && count($form_list)): ?>

<ul class="item-form-list">

<?php $__currentLoopData = $form_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <li class="form-list-item item-group <?php echo e((old('item_group') && old('item_group') == $group['id'])?'active':''); ?>" id="<?php echo e($group['id']); ?>">
        <a href="#" class="item-link nav-item"><?php echo e($group['label']); ?> <i class="fa fa-chevron-right"></i></a>
        <div class="item-form">
            <form method="POST" action="<?php echo e(route('admin.menu.item.save')); ?>" class="menu-item-form add" novalidate>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="menu_id" value="<?php echo e($detail->id); ?>" class="item-inp">
            <input type="hidden" name="type" value="<?php echo e($group['type']); ?>" class="item-inp">
            <input type="hidden" name="sub_type" value="default" class="item-inp">
            <input type="hidden" name="item_group" value="<?php echo e($group['id']); ?>">
            <?php if($group['hidden']): ?>
                <?php $__currentLoopData = $group['hidden']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hInp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($hInp['name']); ?>" class="item-inp" value="<?php echo e($hInp['value']); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($group['inputs']): ?>
                <?php $__currentLoopData = $group['inputs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if(is_array($inp)){
                            $input = new Input($inp);
                        }else{
                            $input = $inputs->get($inp);
                        }
                        if(!$input) {
                                echo $inp.' lỗi sml<br>';
                                continue;
                            }
                        if(!in_array($input->type,['radio','checkbox','checklist'])){
                            $input->addClass('form-control');
                        }
                        $input->id = $group['id'].'-'.$input->id;
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
                            <label for="<?php echo e($group['id'].$input->id); ?>" class="form-control-label"><?php echo e($input->label); ?></label>
                            <?php endif; ?>
                            <?php echo $input; ?>

                            <?php echo ($input->error && old('item_group') && old('item_group') == $group['id'])?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <div class="buttons mt-3">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            </form>
        </div>
    </li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</ul>

<?php endif; ?>