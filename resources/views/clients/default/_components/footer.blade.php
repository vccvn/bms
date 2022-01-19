        <!--Main Footer-->
        <footer class="main-footer">

            <div class="auto-container">
                <div class="row clearfix">


                    <!--Footer Column-->
                    <div class="footer-column col-md-3 col-sm-4 col-xs-12">
                        <div class="footer-widget">
                            <h2>{{$siteinfo->site_name}}</h2>
                            <div class="widget-content">
                                
                                <div class="contacts">
                                    <p class="contact address">
                                        <span class="icon flaticon-placeholder"></span> Địa chỉ: <span>{{$siteinfo->address?$siteinfo->address:'Hà Đông, Hà Nội'}}</span> 
                                    </p>
                                    <p class="contact phone">
                                        <span class="icon flaticon-phone-call"></span> Số điện thoại: <span>{{$siteinfo->phone_number?$siteinfo->phone_number:'0945786960'}}</span> 
                                    </p>
                                    <p class="contact email">
                                        <span class="icon flaticon-envelope"></span> Email: <span>{{$siteinfo->email?$siteinfo->email:'email@site.com'}}</span> 
                                    </p>
                                    
                                </div>

                                <ul class="social-icons light clearfix">
                                    <li><a href="{{$siteinfo->facebook?$siteinfo->facebook:'#'}}"><span class="fa fa-facebook-f"></span></a></li>
                                    <li><a href="{{$siteinfo->twitter?$siteinfo->twitter:'#'}}"><span class="fa fa-twitter"></span></a></li>
                                    <li><a href="{{$siteinfo->googleplus?$siteinfo->googleplus:'#'}}"><span class="fa fa-google-plus"></span></a></li>
                                    <li><a href="{{$siteinfo->linkedin?$siteinfo->linkedin:'#'}}"><span class="fa fa-linkedin"></span></a></li>
                                    <li><a href="{{$siteinfo->pinterest?$siteinfo->pinterest:'#'}}"><span class="fa fa-pinterest-p"></span></a></li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <!--Footer Column-->
                    <div class="footer-column col-md-5 col-sm-4 col-xs-12">
                        <div class="footer-widget">
                            <h2>Bản đồ</h2>
                            <div class="widget-content">
                                {!!$__embed->google_map!!}
                            </div>
                        </div>
                    </div>

                    <!--Footer Column-->
                    <div class="footer-column col-md-4 col-sm-6 col-xs-12">
                        <div class="footer-widget">
                            <h2>Facebook</h2>
                            <div class="widget-content">
                                <div class="fb-page" 
                                     data-href="{{$fp = $siteinfo->facebook?$siteinfo->facebook:'https://www.facebook.com/TheGioiVuong'}}" 
                                     data-tabs="timeline" 
                                     data-height="300" 
                                     data-small-header="false" 
                                     data-adapt-container-width="true" 
                                     data-hide-cover="false" 
                                     data-show-facepile="true">
                                    <blockquote cite="{{$fp}}" class="fb-xfbml-parse-ignore">
                                        <a href="{{$fp}}">{{$siteinfo->site_name}}</a>
                                    </blockquote>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!--Footer Bottom-->
            <div class="footer-bottom">
                <div class="copyright">&copy; {{date('Y')}} {{$siteinfo->site_name}} All Rights Reserved.</div>
            </div>


        </footer>
        <!--End Main Footer-->
        <div class="call-now company-info-item">
            <div class="link">
                <a href="tel:{{$siteinfo->phone_number?$siteinfo->phone_number:'0945786960'}}" ><span class="icon flaticon-phone-call"></span></a>
            </div>                        

        </div>