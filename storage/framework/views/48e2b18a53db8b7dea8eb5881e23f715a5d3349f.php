<?php
    use Cube\Html\Menu;
    $user = Auth::user();
?>
<header class="header">
    <div class="header-block header-block-collapse d-lg-none d-xl-none">
        <button class="collapse-btn" id="sidebar-collapse-btn">
                <i class="fa fa-bars"></i>
            </button>
    </div>
    <div class="header-block header-block-search">
        <form role="search">
            <div class="input-container">
                <i class="fa fa-search"></i>
                <input type="search" placeholder="Search">
                <div class="underline"></div>
            </div>
        </form>
    </div>
    <div class="header-block header-block-buttons">
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fa fa-home"></i>
            <span>Trang chủ</span>
        </a>
    </div>

    <div class="header-block header-block-nav">
        <ul class="nav-profile">
            
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="img" style="background-image: url('<?php echo e($user->getAvatar()); ?>'); backgtound-size:cover;"> </div>
                    <span class="name"> <?php echo e($user->name); ?> </span>
                </a>
                <?php 
                $menu_info = ['type' => 'json','file' => 'profile-actions'];
                $menu_options = [
                    'menu_tag' => 'div', 
                    'menu_class' => 'dropdown-menu profile-dropdown-menu',
                    'item_tag' => null,
                    'link_class' => 'dropdown-item',
                    'use_icon' => true,
                    'icon_class' => 'icon',

                    'aria-labelledby'=>"dropdownMenu1",
                ];
                $menu = (new Menu($menu_info,$menu_options,'profile-actions'))
                    ->addAction(function($item){
                        if($item->isLast()){
                            $item->before('<div class="dropdown-divider"></div>');
                        }
                    });
                ?>
                <?php echo $menu; ?>

                
            </li>
        </ul>
    </div>
</header>