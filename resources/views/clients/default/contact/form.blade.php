
@extends($__layouts.'fullwidth-page-title')

@section('title','Liên hệ')

@section('content')
        
       		<!--Contact Section-->
    <section class="contact-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            
            	<!--Form Column-->
            	<div class="column form-column col-md-7 col-sm-12 col-xs-12">
                	<div class="default-title"><h3>Gửi liên hệ</h3><div class="separator"></div></div>
                    <div class="default-form-area">
                        <form id="contact-form" name="contact_form" class="contact-form default-form" action="{{route('client.contact.ajax-send')}}" method="post">
                            <div class="row clearfix">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    
                                    <div class="form-group style-two">
                                        <input type="text" name="name" class="form-control" value="" placeholder="Họ tên (bắt buộc)" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="email" name="email" class="form-control required email" value="" placeholder="Email (bắt buộc)" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="text" name="phone_number" class="form-control" value="" placeholder="Số điện thoại (tùy chọn)">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="text" name="subject" class="form-control" value="" placeholder="Tiêu đề (tùy chọn)">
                                    </div>
                                </div>  
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <textarea name="content" class="form-control textarea required" placeholder="Nội dung liên hệ (bắt buộc)"></textarea>
                                    </div>
                                </div>                                                
                            </div>
                            <div class="contact-section-btn text-center">
                                <div class="form-group style-two">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button class="theme-btn btn-style-one" type="submit" data-loading-text="Vui lòng chờ giây lát...">Gửi</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
                
                <!--Info Column-->
                <div class="column info-column col-md-5 col-sm-12 col-xs-12">
                
                	<div class="inner-box">
                        <!--Default Title-->
                        <div class="default-title"><h3>Liên hệ chúng tôi</h3><div class="separator"></div></div>
                        <!--Contact Info-->
                        <div class="contact-info">
                            <ul>
                                <li><span class="icon flaticon-placeholder"></span>{{$siteinfo->office?$siteinfo->office:"Hà Đông, Hà Nội"}}</li>
                                <li><span class="icon flaticon-envelope"></span>{{$siteinfo->email}}</li>
                                <li><span class="icon flaticon-phone-call"></span>{{$siteinfo->phone_number}}</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    @if($siteinfo->google_map_lat && $siteinfo->google_map_lng)
   	<!--Map Section-->
    <section class="map-section">
    	<div class="map-outer">
			<!--Map Canvas-->
            <div class="map-canvas"
                data-zoom="13"
                data-lat="{{$siteinfo->google_map_lat}}"
                data-lng="{{$siteinfo->google_map_lng}}"			  
                data-type="roadmap"
                data-hue="#ffc400"
                data-title="{{$siteinfo->google_map_title}}"
                data-content="{{$siteinfo->google_map_contant}}"							
                style="height: 450px;">
            </div>

        </div>
    </section>
	<!--End Map Section-->
    @endif
@endsection

@if($siteinfo->google_map_lat && $siteinfo->google_map_lng)
@section('jsinit')
<script>
    window.onload = function () {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        GmapInit("{{get_theme_url('images/icons/map-marker.png')}}");
        document.body.appendChild(script);
    };

</script>
@endsection
@section('js')
<!--Google Map APi Key-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRvBPo3-t31YFk588DpMYS6EqKf-oGBSI"></script>

<script src="{{get_theme_url('js/map-script.js')}}"></script>
<!--End Google Map APi-->
@endsection

@endif