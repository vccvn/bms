
    <script src="<?php echo e(asset('js/admin/jquery.cropit.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/main.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/str.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/arr.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/fn.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/videos.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/select.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/uploader.js')); ?>"></script>
    

    <?php if($user = Auth::user()): ?>
        <?php if($user->meta('user_group')=='dev'): ?>
            <script>
                $(function(){
                    $('.dev-only').removeClass('dev-only');
                });
            </script>
        <?php endif; ?>
    <?php endif; ?>