Xin chào <?php echo e($data['admin']); ?>,
<br>
<br>
<?php echo e($data['name']); ?> vừa gửi liên hệ với những thông tin sau: 
<br>
<br>
<?php if($data): ?>

    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php echo e($k); ?>: <?php echo e($v); ?> <br>
    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>