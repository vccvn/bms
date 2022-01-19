<header class=" p-0 position-relative " style="min-height:400px;" >
            <div class=" index mb-3 position-relative bg-white" id="header-top" >
                <div class="container index pr-0"  >
                    <!-- Nav top banner -->
                    <div class="col-md-12 pr-0 ">
                        <div class="navbar-top row p-0 pb-3 pt-3">
                            <div class="col-md-9 row contact-header">
                                <div class="col-md-3 p-0 phone">
                                    <a href="#" class="d-inline-flex">
                                    <i class="icon mdi mdi-phone  rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                                    <span class="align-items-center d-gird pl-2 text-dark">+84 967 62 9997</span>
                                    </a>
                                </div>
                                <div class="col-md-4 p-0 email">
                                    <a href="#" class="d-inline-flex">
                                    <i class="icon mdi mdi-email-outline rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                                    <span class="align-items-center d-gird pl-2 text-dark">bms@gmail.com</span>
                                    </a>
                                </div>
                                <div class="col-md-5 p-0 address">
                                    <a href="#" class="d-inline-flex">
                                    <i class="icon mdi mdi-map-marker rounded-circle text-white bg-primary d-gird text-center align-items-center border border-primary"></i>
                                    <span class="align-items-center d-gird pl-2 text-dark">Hàm Nghi - Mỹ Đình - Hà Nội</span>
                                    </a>
                                </div>
                            </div>
                            <div class="right-side col-md-3 p-0">
                                <div class="d-inline-flex float-right">
                                    <a href="#">
                                    <i class="icon-xs mdi mdi-facebook rounded-circle text-white  d-gird text-center align-items-center ml-2 hv"></i>
                                    </a>
                                    <a href="#" >
                                    <i class="icon-xs mdi mdi-twitter rounded-circle text-white  d-gird text-center align-items-center ml-2 hv2"></i>
                                    </a>
                                    <a href="#" >
                                    <i class="icon-xs fab fa-google-plus-g rounded-circle text-white  d-gird text-center align-items-center ml-2 hv3"></i>
                                    </a>
                                    <a href="#" >
                                    <i class="icon-xs fab fa-instagram rounded-circle text-white  d-gird text-center align-items-center ml-2 hv4"></i>
                                    </a>
                                    <a href="#" >
                                    <i class="icon-xs fa fa-rss rounded-circle text-white  d-gird text-center align-items-center ml-2 hv5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid index" id="header-menu" style="top: 0px">
                <div class="container position-relative index">
                    <div class="navbar-bottom row">
                        <div class="navbar-logo col-md-3 ">
                            <a href="#"><img src="{{get_theme_url('images/logo.png')}}"></a>
                        </div>
                        <div class="navbar-menu col-md-8 d-gird align-items-center">
                            <nav class="navbar navbar-expand-sm">
                                <!-- Links -->
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{route('client.home')}}">Trang chủ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white active" href="{{route('client.about')}}">Giới thiệu</a>
                                    </li>
                                    <!-- Dropdown -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop" data-toggle="dropdown">
                                       Tuyến xe
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-primary"  href="#"><i class="chevron mdi-chevron-right mdi text-muted "></i><span>Link 1</span></a>
                                            <a class="dropdown-item text-primary"  href="#"><i class="chevron mdi-chevron-right mdi text-muted "></i><span>Link 1</span></a>
                                            <a class="dropdown-item text-primary"  href="#"><i class="chevron mdi-chevron-right mdi text-muted "></i><span>Link 1</span></a>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('client.news')}}">Tin tức</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('client.lien-he')}}">Liên hệ</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-1 navbar-search d-gird align-items-center">
                            <a href="#"><i class="fa fa-search text-white "></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-slide position-absolute container-fluid p-0">
                <div class="mySlides fades mySlides3">
                    <div class="bk-grba">
                        <div class="info-page container">
                            @if($title)
                            <h2 class="title-page">{{$title}}</h2>
                            <div class="list-inline">
                                <ul>
                                    <li><a href="#">Trang chủ</a></li>
                                    <li>{{$title}}</li>
                                </ul>
                            </div>
                            @else
                        	<h2 class="title-page">Giới thiệu</h2>
                        	<div class="list-inline">
                        		<ul>
                        			<li><a href="#">Trang chủ</a></li>
                        			<li>Giới thiệu</li>
                        		</ul>
                        	</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>