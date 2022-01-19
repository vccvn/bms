<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make($__utils.'meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__templates.'links', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <?php echo $__env->make($__utils.'setting-data', ['prefix'=>'head'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        

    </head>
    <body>
        <?php echo $__env->make($__utils.'setting-data', ['prefix'=>'body_top'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make($__components.'header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__components.'page-header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        
        <main class="main d-block ">
            <?php echo $__env->yieldContent('content'); ?>
        </main>


        <?php echo $__env->make($__components.'footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__utils.'modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__templates.'js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__utils.'js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make($__utils.'setting-data', ['prefix'=>'body_bottom'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
    </body>
</html>