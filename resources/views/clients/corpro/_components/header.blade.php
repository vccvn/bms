<?php
use Cube\Html\Menu;
use Cube\Html\HTML;

?>
<header class=" p-0 position-relative " style="min-height:600px;" >
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
                                        <a class="nav-link text-white active" href="{{route('client.home')}}">Trang chủ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="{{route('client.about')}}">Giới thiệu</a>
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
                <div class="mySlides fades mySlides1" >
                    <div class="bk-grba">
                        <div class="text container">
                            <h3 class="text-white text-bold">TIỆN NGHI & PHONG CÁCH</h3>
                            <p class="text-white">BMS là trang web truy cập hàng đầu để<br> đặt xe liên tỉnh</p>
                            <a href="#" class="text-white btn p4 pl-5 pr-5 border btn-skew">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <div class="mySlides fades mySlides2">
                    <div class="bk-grba">
                        <div class="text container">
                            <h3 class="text-white text-bold">TIỆN NGHI & PHONG CÁCH</h3>
                            <p class="text-white">BMS là trang web truy cập hàng đầu để<br> đặt xe liên tỉnh</p>
                            <a href="#" class="text-white btn p4 pl-5 pr-5 border btn-skew">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <div class="mySlides fades mySlides3">
                    <div class="bk-grba">
                        <div class="text container">
                            <h3 class="text-white text-bold">TIỆN NGHI & PHONG CÁCH</h3>
                            <p class="text-white">BMS là trang web truy cập hàng đầu để<br> đặt xe liên tỉnh</p>
                            <a href="#" class="text-white btn p4 pl-5 pr-5 border btn-skew">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <a class="prev position-absolute" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next position-absolute" onclick="plusSlides(1)">&#10095;</a> 
                <div class="container-fluid position-absolute" style="bottom: 0px">
                    <div class="container header-filter " >
                        <div class="col-md-12 p-0">
                            <div class="main-filter p-4">
                                <h3 class="pb-2">
                                    <span class="text-bold text-white pl-3">Tìm vé xe</span>
                                </h3>
                                <form action="./list-buses.html">
                                    <div class="col-md-12 row">
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="to" class="text-white">Điểm đi</label>
                                                <select class="form-control" disabled>
                                                    <option value="" selected="selected">Bến xe T4D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="from" class="text-white">Điểm đến</label>
                                                <select class="form-control">
                                                    @foreach($stations as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-unset">
                                                <label for="from" class="text-white">Ngày đi</label>
                                                <select class="form-control">
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                    <option value="">19/10/2018</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center align-items-end d-gird">
                                            <div class="form-group d-unset mb-0">
                                                <button type="submit" class="btn">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>


