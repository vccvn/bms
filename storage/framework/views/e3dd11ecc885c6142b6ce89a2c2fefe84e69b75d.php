
    <script src="<?php echo e(get_theme_url('js/jquery.js')); ?>"></script>
    <script src="<?php echo e(get_theme_url('js/bootstrap.min.js')); ?>"></script>
   
    <script src="<?php echo e(get_theme_url('js/header.js')); ?>"></script>
     <script src="<?php echo e(get_theme_url('owl-carousel/dist/owl.carousel.min.js')); ?>"></script>
    <script>
        window.cartInit = function() {
            Cube.cart.init({
                urls:{
                    add: '<?php echo e(route('client.cart.add')); ?>',
                    remove: '<?php echo e(route('client.cart.remove')); ?>',
                    update: '<?php echo e(route('client.cart.update')); ?>',
                    update_by_key: '<?php echo e(route('client.cart.update-by-key')); ?>',
                    update_cart: '<?php echo e(route('client.cart.update-cart')); ?>',
                    refresh: '<?php echo e(route('client.cart.refresh')); ?>',
                    empty: '<?php echo e(route('client.cart.empty')); ?>',
                    checkout: '<?php echo e(route('client.cart.checkout')); ?>'
                    
                },
                VAT: <?php echo e($__setting->VAT?$__setting->VAT:0); ?>

            });
        };

        window.authInit = function() {
            Cube.auth.init({
                urls:{
                    check: '<?php echo e(route('client.auth.check')); ?>'
                },
                templates:{
                    auth: 'Xin chào, <a class="theme_color" href="<?php echo e(route('user.profile')); ?>">{$name}</a> [ <a class="theme_color" href="<?php echo e(route('client.auth.logout')); ?>">Thoát</a> ]',
                    guest: "Chào mừng bạn đã đến với <?php echo e($siteinfo->site_name); ?>"
                }
            });
        };


        window.commentsInit = function() {
            Cube.comments.init({
                urls:{
                    save_url: '<?php echo e(route('client.comment.ajax-save')); ?>'
                    
                }
            });
        };

        
    </script>
    <?php echo $__env->yieldContent('jsinit'); ?>

    <?php echo $__env->yieldContent('js'); ?>

    <?php echo $__env->yieldContent('template.js'); ?>

    