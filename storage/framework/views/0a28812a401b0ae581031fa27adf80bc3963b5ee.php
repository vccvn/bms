<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $__env->yieldContent('title', 'Profile'); ?> | <?php echo e($siteinfo->site_name); ?> </title>
    <meta name="description" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo e(asset('themes/addmin/apple-touch-icon.png')); ?>">
    <?php echo $__env->make('user.profile.templates.css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <div class="main-wrapper">
        <div class="app" id="app">
            
            <?php echo $__env->make('panel._templates.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

            <?php echo $__env->make('user.profile.templates.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            
            <?php echo $__env->yieldContent('content'); ?>
            
            <?php echo $__env->make('panel._templates.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            
            <?php echo $__env->make('user.profile.templates.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->yieldContent('modal'); ?>

        </div>
    </div>
    <?php echo $__env->yieldContent('jsinit'); ?>
    <?php echo $__env->make('panel._templates.theme-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('panel._templates.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('js'); ?>
</body>

</html>