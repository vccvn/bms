<?php
$user = auth()->user();
?>

<footer class="sidebar-footer">
    <ul class="sidebar-menu metismenu" id="customize-menu">
        <li>
            <?php if($user->isAdmin()): ?>
             <ul>
                <li class="customize text-left">
                    <a href="<?php echo e(route('admin.option.group',['group'=>'siteinfo'])); ?>" class="d-block pt-2 pb-2">
                        <i class="fa fa-info-circle"></i> Thông tin website
                    </a>
                    <a href="<?php echo e(route('admin.option.group',['group'=>'setting'])); ?>" class="d-block pt-2 pb-2">
                        <i class="fa fa-wrench"></i> Các cài đặt
                    </a>
                    <a href="<?php echo e(route('admin.option.group',['group'=>'embed'])); ?>" class="d-block pt-2 pb-2">
                        <i class="fa fa-code"></i> Mã nhúng
                    </a>

                    <a href="<?php echo e(route('admin.menu')); ?>" class="d-block pt-2 pb-2">
                        <i class="fa fa-bars"></i> Menu
                    </a>

                    <a href="<?php echo e(route('admin.slider')); ?>" class="d-block pt-2 pb-2">
                        <i class="fa fa-picture-o"></i> Slider
                    </a>

                    
                </li>
            </ul>
            <a href="#">
                <i class="fa fa-cogs"></i> Thiết lập 
            </a> 
            <?php endif; ?>
        </li>
    </ul>
</footer>