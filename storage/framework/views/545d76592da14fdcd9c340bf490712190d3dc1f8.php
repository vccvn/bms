<?php $__env->startSection('title', 'Thông báo'); ?>

<?php $__env->startSection('content'); ?>

<?php
$t = $type?$type:'success';

?>

<p class="alert alert-<?php echo e($t); ?>"><?php echo e($message); ?></p>

<div class="text-center">
	<?php if(!isset($link) || !$link): ?>
		<a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Về trang chủ</a>
	<?php else: ?>
		<a href="<?php echo e($link); ?>" class="btn btn-primary"><?php echo e($text?$text:"Go"); ?></a>
	<?php endif; ?>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('panel._layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>