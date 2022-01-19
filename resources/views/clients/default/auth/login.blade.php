
@extends($__layouts.'fullwidth-page-title')

@section('title','Đăng nhập')

@section('content')
        
    <!--Login Section-->
    <section class="contact-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            
            	<!--Form Column-->
            	<div class="column form-column col-md-6 col-sm-6 col-xs-12">
                	<div class="default-title"><h3>Đăng nhập</h3><div class="separator"></div></div>
                    <div class="default-form-area">
                        <form id="login-form" name="login_form" class="login-form default-form" action="{{route('client.auth.login')}}" method="post" novalidate>
                            @csrf
                            @if(session('error'))
                                <div class="alert alert-warning">{{session('error')}}</div>
                            @elseif(session('register'))
                                <div class="alert alert-success">{{session('register')}}</div>
                            @endif
                            <div class="row clearfix">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    
                                    <div class="form-group style-two">
                                        <input type="text" name="username" id="username" class="form-control required {{$errors->has('username')?'error':''}}" value="{{old('username')}}" placeholder="Tài khoản" required="">
                                        @if($errors->has('username'))
                                            <label id="username-error" class="error" for="username">{{$errors->first('username')}}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="password" name="password" id="password" class="form-control required password {{$errors->has('password')?'error':''}}" value="" placeholder="Mật khẩu" required="">
                                        @if($errors->has('password'))
                                            <label id="password-error" class="error" for="password">{{$errors->first('password')}}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="">
                                        <label for="remember">
                                            <input type="checkbox" name="remember" id="remember" {{old('remember')?'checked':''}} /> Duy trì đăng nhập
                                        </label>

                                    </div>
                                    <div class="form-group"></div>
                                </div>
                                
                                
                            </div>
                            <div class="contact-section-btn text-center">
                                <div class="form-group style-two">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button class="theme-btn btn-style-one" type="submit" data-loading-text="Vui lòng chờ giây lát...">Đăng nhập</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
                
                <!--Info Column-->
                <div class="column info-column col-md-6 col-sm-6 col-xs-12">
                
                	<div class="inner-box">
                        <!--Default Title-->
                        <div class="default-title"><h3>Liên hệ chúng tôi</h3><div class="separator"></div></div>
                        <!--Contact Info-->
                        <div class="contact-info">
                            <ul>
                                <li><span class="icon flaticon-placeholder"></span>{{$siteinfo->short_address}}</li>
                                <li><span class="icon flaticon-envelope"></span>{{$siteinfo->email}}</li>
                                <li><span class="icon flaticon-phone-call"></span>{{$siteinfo->phone_number}}</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

@endsection
