
    <script>
            
    
    
            window.commentsInit = function() {
                Cube.comments.init({
                    urls:{
                        save_url: '<?php echo e(route('client.comment.ajax-save')); ?>'
                        
                    }
                });
            };
    
            
        </script>
        <?php echo $__env->yieldContent('jsinit'); ?>
    
        <script src="<?php echo e(asset('js/cube/main.js')); ?>"></script>
        <script src="<?php echo e(asset('js/cube/storage.js')); ?>"></script>
        <script src="<?php echo e(asset('js/cube/str.js')); ?>"></script>
        <script src="<?php echo e(asset('js/cube/videos.js')); ?>"></script>
        <script src="<?php echo e(asset('js/cube/select.js')); ?>"></script>
        
        
        <script src="<?php echo e(asset('js/client/validate.js')); ?>"></script>
        <script src="<?php echo e(asset('js/client/comments.js')); ?>"></script>
        <script src="<?php echo e(asset('js/client/utils.js')); ?>"></script>
        <script src="<?php echo e(asset('js/client/subcribe.js')); ?>"></script>
        
        <?php echo $__env->yieldContent('js'); ?>
    
        <?php echo $__env->yieldContent('template.js'); ?>