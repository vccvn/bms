<?php
use Cube\Html\Menu;
use Cube\Html\HTML;

?>
<header class="main-header header-style-two">

    <!--Header Top-->

    <div class="header-top">
        <div class="auto-container clearfix">
            <!--Top Left-->
            <div class="top-left pull-left">
                
                <p id="header-auth-block">Chào mừng bạn đến với {{$siteinfo->site_name}}</p>
                
            </div>
            
            <!--Top Right-->
            <div class="top-right pull-right">
            
                <ul class="social-icons clearfix">
                    <li><a href="{{$siteinfo->facebook?$siteinfo->facebook:'#'}}"><span class="fa fa-facebook-f"></span></a></li>
                    <li><a href="{{$siteinfo->twitter?$siteinfo->twitter:'#'}}"><span class="fa fa-twitter"></span></a></li>
                    <li><a href="{{$siteinfo->googleplus?$siteinfo->googleplus:'#'}}"><span class="fa fa-google-plus"></span></a></li>
                    <li><a href="{{$siteinfo->linkedin?$siteinfo->linkedin:'#'}}"><span class="fa fa-linkedin"></span></a></li>
                    <li><a href="{{$siteinfo->pinterest?$siteinfo->pinterest:'#'}}"><span class="fa fa-pinterest-p"></span></a></li>
                    
                </ul>
            </div>
        </div>
    </div><!--End Header Top-->
    <!--End Header Top-->

    <!--Header-Upper-->
    <div class="header-upper">
        <div class="auto-container">
            <div class="clearfix">

                <div class="pull-left logo-outer ">
                    {{-- {{$siteinfo->slogan?'has-slogan':''}} --}}
                    <div class="logo">
                        <a href="{{route('home')}}"><img src="{{$siteinfo->logo?$siteinfo->logo:get_theme_url('images/logo.png')}}" alt="{{$siteinfo->site_name}}" title="{{$siteinfo->site_name}}"></a>
                    </div>
                    {{-- <p class="slogan">{{$siteinfo->slogan?$siteinfo->slogan:"Một sản phẩm của Light Solution"}}</p> --}}
                </div>

                <div class="pull-right upper-right clearfix">

                    <!--Info Box-->
                    <div class="upper-column info-box phone">
                        <div class="icon-box"><span class="flaticon-headphones"></span></div>
                        Hotline
                        <div class="light-text">{{$siteinfo->phone_number?$siteinfo->phone_number:'+8494.578.6960'}}</div>
                    </div>

                    <!--Info Box-->
                    <div class="upper-column info-box email">
                        <div class="icon-box"><span class="flaticon-envelope"></span></div>
                        Email
                        <div class="light-text">{{$siteinfo->email?$siteinfo->email:'doanln16@gmail.com'}}</div>
                    </div>

                    <!--Info Box-->
                    <div class="upper-column info-box address">
                        <div class="icon-box"><span class="flaticon-placeholder"></span></div>
                        Văn phòng
                        <div class="light-text">{{$siteinfo->office?$siteinfo->office:'Mỹ Đình, Hà Nội'}}</div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    






    <?php 
                                    
    $menu_props = [
        'className' => 'navigation clearfix',
        'item_active_class' => 'current',
        'has_sub_class' => 'dropdown'
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
    
    // $menu_props['className'] = 'mobile-menu clearfix';
    $mobile_menu = new Menu($main_menu,$menu_props,'main_menu');
    ?>

    <div class="header-bottom" id="header-bottom-static">
        <div class="auto-container">
            <div class="clearfix">

                <div class="nav-outer clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            {!! $menu !!}
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                    <div class="btn-outer">
                        <ul>
                            <li class="cart-item-btn">
                                <a href="{{route('client.cart')}}" class="cart-btn cart-box-btn"><span class="icon fa fa-shopping-cart"></span> <span class="cart-qty">0</span></a>
                            </li>
                            <li>
                                <a href="#" class="search-btn search-box-btn"><span class="icon fa fa-search"></span></a>
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Sticky Header-->
    <div class="sticky-header">
        <div class="auto-container clearfix">
            <!--Logo-->
            <div class="logo pull-left">
                <a href="{{route('home')}}"><img src="{{$siteinfo->mobile_logo?$siteinfo->mobile_logo:($siteinfo->logo?$siteinfo->logo:get_theme_url('images/logo.png'))}}" alt="{{$siteinfo->site_name}}" title="{{$siteinfo->site_name}}"></a>
            </div>

            <!--Right Col-->
            <div class="right-col pull-right menu-block">
                <!-- Main Menu -->
                <nav class="main-menu">
                    <div class="navbar-header">
                        <!-- Toggle Button -->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="navbar-collapse collapse clearfix">
                        {!!$mobile_menu!!}
                    </div>
                </nav>
                 <!-- Main Menu End-->
                 <div class="btn-outer">
                    <ul>
                        {{-- <li class="cart-item-btn">
                            <a href="{{route('client.cart')}}" class="cart-btn cart-box-btn"><span class="icon fa fa-shopping-cart"></span> <span class="cart-qty">0</span></a>
                        </li> --}}
                        <li>
                            <a href="#" class="search-btn search-box-btn"><span class="icon fa fa-search"></span></a>
                        </li>
                        
                        
                    </ul>
                </div>
                <!-- Main Menu End-->
            </div>

        </div>
    </div>
    <!--End Sticky Header-->

</header>


