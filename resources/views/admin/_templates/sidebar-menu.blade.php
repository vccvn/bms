<?php
use Cube\Html\Menu;
?>
<nav class="menu">
    <?php 
    
    $menu_options = [
        'id' => 'sidebar-menu',
        'class' => 'sidebar-menu metismenu',
        'sub_class' => 'sidebar-nav',
        'has_sub_active_class' => 'open',
        'sub_item_active_class' => 'active',
        'use_icon' => true
    ];
    $menu = (new Menu($admin_menu,$menu_options,'admin_menu'))
        ->addAction(function($item,$link){
            if($item->hasSubMenu()){
                $link->append( ' <i class="fa arrow"></i>' );
            }
        });
    ?>
    {!! $menu !!}
</nav>