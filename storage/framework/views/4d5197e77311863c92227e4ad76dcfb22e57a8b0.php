<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('clients._templates.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make($__theme.'_templates.links', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->make('clients._templates.setting-data', ['prefix'=>'head'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>

<body>
    <?php echo $__env->make('clients._templates.setting-data', ['prefix'=>'body_top'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- Main Header -->
        <?php echo $__env->make($__theme.'_components.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--End Main Header -->

        <!-- content -->

        <?php echo $__env->yieldContent('content'); ?>

        <!-- /.content -->

        <!--Main Footer-->
        <?php echo $__env->make($__theme.'_components.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--End Main Footer-->

    </div>
    <!--End pagewrapper-->

    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="fa fa-long-arrow-up"></span></div>

    <?php echo $__env->make($__theme.'_templates.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!--Search Popup-->

  

    <!--End Search Popup-->

    <?php echo $__env->make($__theme.'_templates.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('clients._templates.setting-data', ['prefix'=>'body_bottom'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
</body>

</html>