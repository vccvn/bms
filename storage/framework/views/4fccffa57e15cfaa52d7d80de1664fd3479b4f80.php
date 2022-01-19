
    <script src="<?php echo e(asset('js/admin/jquery.cropit.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/main.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/str.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/arr.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/fn.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/videos.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/select.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/uploader.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cube/datetime.js')); ?>"></script>
    
    
    <script src="<?php echo e(asset('js/admin/items.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/users.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/modules.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/menus.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/permissions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/categories.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/products.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/product-categories.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/posts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/pages.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/sliders.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/slugs.js')); ?>"></script>
    

    <?php if($user = Auth::user()): ?>
        <?php if($user->meta('user_group')=='dev'): ?>
            <script>
                $(function(){
                    $('.dev-only').removeClass('dev-only');
                });
            </script>
        <?php endif; ?>
    <?php endif; ?>