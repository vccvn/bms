<?php
use Cube\Html\Menu;
use Cube\Html\HTML;

?>

<header class="main-header">
    <div class=" index mb-1 position-relative bg-white" id="header-top"  >
        <div class="container index pr-0"  >
            <!-- Nav top banner -->
            <div class="col-md-12 pr-0 ">
                <div class="navbar-top row p-0 pb-2 pt-2">
                    <div class="col-md-9 row contact-header">
                        <div class="col-md-3 p-0 phone">
                            <a href="tel:<?php echo e($pn = $siteinfo->phone_number('0945786960')); ?>" class="d-inline-flex">
                            <i class="icon mdi mdi-phone  rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                            <span class="align-items-center d-gird pl-2 text-dark"><?php echo e($pn); ?></span>
                            </a>
                        </div>
                        <div class="col-md-3 p-0 email">
                            <a href="mailto:<?php echo e($em = $siteinfo->email('doanln16@gmail.com')); ?>" class="d-inline-flex">
                            <i class="icon mdi mdi-email-outline rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                            <span class="align-items-center d-gird pl-2 text-dark"><?php echo e($em); ?></span>
                            </a>
                        </div>
                        <div class="col-md-auto p-0 address">
                            <a href="<?php echo e($siteinfo->map_url('#')); ?>" class="d-inline-flex">
                            <i class="icon mdi mdi-map-marker rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                            <span class="align-items-center d-gird pl-2 text-dark"><?php echo e($siteinfo->office('Hàm Nghi, Mỹ Đình, Hà Nội')); ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="right-side col-md-3 p-0">
                        <div class="d-inline-flex float-right">
                            <a href="<?php echo e($siteinfo->facebook('#')); ?>">
                            <i class="icon-xs mdi mdi-facebook rounded-circle text-white  d-gird text-center align-items-center ml-2 hv"></i>
                            </a>
                            <a href="<?php echo e($siteinfo->twitter('#')); ?>" >
                            <i class="icon-xs mdi mdi-twitter rounded-circle text-white  d-gird text-center align-items-center ml-2 hv2"></i>
                            </a>
                            <a href="<?php echo e($siteinfo->google_plus('#')); ?>" >
                            <i class="icon-xs mdi mdi-google-plus rounded-circle text-white  d-gird text-center align-items-center ml-2 hv"></i>
                            </a>
                            <a href="<?php echo e($siteinfo->instagram('#')); ?>" >
                            <i class="icon-xs mdi mdi-instagram rounded-circle text-white  d-gird text-center align-items-center ml-2 hv4"></i>
                            </a>
                            <a href="<?php echo e($siteinfo->rss_url('#')); ?>" >
                            <i class="icon-xs mdi mdi-rss rounded-circle text-white  d-gird text-center align-items-center ml-2 hv5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid index" id="header-menu" style="top: 0px;">
        <div class="container position-relative index">
            <div class="navbar-bottom row">
                <div class="navbar-logo col-sm-2">
                    <a href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e($siteinfo->logo(theme_asset('images/logo.png'))); ?>">
                    </a>
                </div>
                <div class="navbar-menu col-lg-10 col-sm-10 col-xs-5 " id="navbar-menu" >


                    <?php 
                                    
                    $menu_props = [
                        'className' => 'navbar-nav main-menu',
                        'item_class' => 'nav-item',
                        'item_active_class' => 'active',
                        'link_class' => 'nav-link text-white',
                        'id' => 'custom-menu',
                        'has_sub_class' => 'has-sub',
                        'sub_class' => 'sub-menu',
                        'sub_item_class' => 'sub-item',
                        'sub_link_class' => 'sub-link',
                        
                    ];
                    $mm = $main_menu;
                    // $mm['list'][] = [
                    //     'url' => route('client.cart'),
                    //     'title' => 'Giỏ hàng',
                    //     'text' => '<span class="cart-total">'.$total.'</span>',
                    //     'active_key' =>'cart',
                    //     'icon' => 'shopping-cart',
                    //     'class' => 'tt-shopping-cart'
                    // ];
                
                    $menu = new Menu($mm,$menu_props,'main_menu');
                    $menu->addAction(function($item, $link){
                        if($item->isLast()){
                            $item->after('
                                <li class=" navbar-search ml-auto">
                                    <a href="#" class="btn-show-form">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    
                                    <div class="dynamic-search-form-block">
                                        <form class="dynamic-search-form" action="'.route('client.search').'" method="get">
                                            <input type="text" class="form-control search-input" name="s" placeholder="Tìm kiếm"/>
                                        </form>
                                    </div>
                                    
                                </li>
                            
                            ');
                        }
                    });
                    ?>

                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler btn-navbar" type="button" data-toggle="collapse" data-target="#main-menu" 
                            aria-controls="menu" aria-expanded="false">
                            <span class="mdi mdi-menu"></span>
                          </button>
                        <!-- Links -->
                        <div class=" collapse navbar-collapse" id="main-menu">
                            <?php echo $menu; ?>

                        </div>
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
