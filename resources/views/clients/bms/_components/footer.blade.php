<footer class="main-footer bg-blue" style="border-top: 1px solid #000">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-10 col-md-7  mx-auto">
                <div class="footer-logo">
                    <img id="footer-logo" src="{{$siteinfo->logo(theme_asset('images/logo.png'))}}">
                </div>
                <p id="footer-home-font" class="text-center mt-3">{{$siteinfo->description('BMS là trang web truy cập hàng đầu để đặt vé xe buýt liên thành phố trực tuyến. Hệ thống đặt vé của chúng tôi cho phép du khách tìm kiếm và đặt vé xe buýt cho hơn một trăm công ty xe buýt trên khắp Việt Nam')}}</p>
            </div>
            <div class="col-lg-4  col-10 col-md-7  mx-auto">
                <h3 class="main-footer-heading">Liên Hệ</h3>
                <div class="main-footer-contact">
                    <div class="">
                        <a href="tel:{{$pn = $siteinfo->phone_number('0945786960')}}" class="">
                            <span class="badge badge-pill badge-primary main-footer-icon d-inline-flex">
                                <i class="fas fa-phone"></i>
                            </span>
                            <span id="footer-home-font">{{$pn}}</span>
                        </a>
                        
                    </div>
                    <div class="">
                        <a href="mailto:{{$em = $siteinfo->email('doanln16@gmail.com')}}">
                            <span class="badge badge-pill badge-primary main-footer-icon d-inline-flex">
                                <i class="fas fa-mail-bulk"></i>
                            </span>
                            <span id="footer-home-font">{{$em}}</span>
                        </a>
                        
                    </div>
                    <div class="">
                        <a href="{{$siteinfo->map_url('#')}}" class="">
                            <span class="badge badge-pill badge-primary main-footer-icon d-inline-flex">
                                <i class="fas fa-map"></i>
                            </span>
                            <span id="footer-home-font">{{$siteinfo->office('Hàm Nghi, Mỹ Đình, Hà Nội')}}i</span>
                            
                        </a>
                        
                    </div>
                    <br>
                    <div class="footer-icon">
                        <a href="{{$siteinfo->facebook('#')}}" class="col-md-2 badge badge-pill badge-light main-footer-icon main-footer-icon-social"><i class="fab fa-facebook"></i></a>
                        <a href="{{$siteinfo->twitter('#')}}" class="col-md-2 badge badge-pill badge-light main-footer-icon main-footer-icon-social"><i class="fab fa-twitter-square"></i></a>
                        <a href="{{$siteinfo->google_plus('#')}}" class="col-md-2 badge badge-pill badge-light main-footer-icon main-footer-icon-social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="{{$siteinfo->instagram('#')}}" class="col-md-2 badge badge-pill badge-light main-footer-icon main-footer-icon-social"><i class="fab fa-instagram"></i></a>
                        <a href="{{$siteinfo->rss_url('#')}}" class="col-md-2 badge badge-pill badge-light main-footer-icon main-footer-icon-social"><i class="fas fa-rss"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-10 col-md-7 mx-auto">
                <h3 class="main-footer-heading">Bản Tin</h3>
                <p id="footer-home-font">Nhập địa chỉ email của bạn để nhận tin tức mới nhất về BMS, các sự kiện đặc biệt và các hoạt động sinh viên được gửi ngay đến hộp thư đến của bạn.</p>
                <form method="POST" action="{{route('client.subcriber.ajax-send')}}" class="subcribe-form" id="subcribe-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="email" id="sub-email" placeholder="Nhập email...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </div>
                    <p class="error_sub text-white mt-1"></p>
                </form>
            </div>
        </div>
    </div>
    <div class="main-footer-sub">
        <div class="container">
            <div class="row col-md-12">
                <p id="footer-home-font">&copy; {{date('Y')}} Tất cả các điều khoản sử dụng và chính sách bảo mật</p>
            </div>
        </div>
    </div>
</footer>
