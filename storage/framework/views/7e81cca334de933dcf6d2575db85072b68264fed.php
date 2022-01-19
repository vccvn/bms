
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo $__env->yieldContent('title', "Trang chủ"); ?> | <?php echo e($siteinfo->site_name?$siteinfo->site_name:'Light Solution'); ?></title>
    <meta property="og:site_name" content="<?php echo e($siteinfo->site_name); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
   

    <meta name="title" content="<?php echo $__env->yieldContent('meta_title', $__env->yieldContent('title', "Trang chủ").' | '.$siteinfo->site_name?$siteinfo->site_name:'Light Solution'); ?>)">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', $__env->yieldContent('description', $siteinfo->description)); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', $siteinfo->keywords); ?>">
    <meta name="image" content="<?php echo $__env->yieldContent('image', $siteinfo->image); ?>">

    
    
    <?php echo $__env->make('clients._templates.meta-seo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    
