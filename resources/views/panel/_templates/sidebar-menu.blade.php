<?php
use Cube\Html\Menu;
?>
<nav class="menu">
    <?php 
    if(!isset($profile_menu)) $profile_menu = ['type' => 'json','file' => 'profile'];
    $menu_options = [
        'id' => 'sidebar-menu',
        'class' => 'sidebar-menu metismenu',
        'sub_class' => 'sidebar-nav',
        'has_sub_active_class' => 'open',
        'sub_item_active_class' => 'active',
        'use_icon' => true
    ];
    $menu = (new Menu($profile_menu,$menu_options,'manager_menu'))
        ->addAction(function($item,$link){
            if($item->hasSubMenu()){
                $link->append( ' <i class="fa arrow"></i>' );
            }
        });
    ?>
    {!! $menu !!}
</nav>