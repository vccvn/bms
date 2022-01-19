<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $__env->yieldContent('title', 'Trang quản trị'); ?> | <?php echo e($siteinfo->site_name); ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo e(asset('themes/addmin/apple-touch-icon.png')); ?>">
    <?php echo $__env->make('panel._templates.css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>
    
    <?php echo $__env->make('panel._templates.clean-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->yieldContent('js'); ?>
</body>

</html>