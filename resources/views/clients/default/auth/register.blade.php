
@extends($__layouts.'fullwidth-page-title')

@section('title','Đăng ký tài khoản')

@section('content')
        
    <!--register Section-->
    <section class="contact-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            
            	<!--Form Column-->
            	<div class="column form-column col-md-7 col-sm-7 col-xs-12">
                	<div class="default-title"><h3>Đăng ký tài khoản</h3><div class="separator"></div></div>
                    <div class="default-form-area">
                        <form id="register-form" name="register_form" class="register-form default-form" action="{{route('client.auth.register')}}" method="post" novalidate>
                            @csrf
                            <div class="row clearfix">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="text" name="name" id="name" class="form-control required {{$errors->has('name')?'error':''}}" value="{{old('name')}}" placeholder="Họ và tên" required="">
                                        @if($errors->has('name'))
                                            <label id="name-error" class="error" for="name">{{$errors->first('name')}}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div class="form-group style-two">
                                        <input type="text" name="username" id="username" class="form-control required {{$errors->has('username')?'error':''}}" value="{{old('username')}}" placeholder="Tên đăng nhập" required="">
                                        @if($errors->has('username'))
                                            <label id="username-error" class="error" for="username">{{$errors->first('username')}}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    
                                    <div class="form-group style-two">
                                        <input type="email" name="email" id="email" class="form-control required {{$errors->has('email')?'error':''}}" value="{{old('email')}}" placeholder="Email" required="">
                                        @if($errors->has('email'))
                                            <label id="email-error" class="error" for="email">{{$errors->first('email')}}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 col-6-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="password" name="password" id="password" class="form-control required password {{$errors->has('password')?'error':''}}" value="" placeholder="Mật khẩu" required="">
                                        @if($errors->has('password'))
                                            <label id="password-error" class="error" for="password">{{$errors->first('password')}}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-6-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control required password {{$errors->has('password_confirmation')?'error':''}}" value="" placeholder="Nhập lại mật khẩu" required="">
                                        @if($errors->has('password_confirmation'))
                                            <label id="password_confirmation-error" class="error" for="password_confirmation">{{$errors->first('password_confirmation')}}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="">
                                        <label for="agree">
                                            <input type="checkbox" name="agree" id="agree" class="{{$errors->has('password')?'error':''}}" {{old('agree')?'checked':''}} /> Tôi đồng ý với các <a href="#">điều khoản</a> của {{$siteinfo->site_name}}
                                        </label>
                                        @if($errors->has('agree'))
                                            <label id="agree-error" class="error" for="agree">{{$errors->first('agree')}}</label>
                                        @endif
                                    </div>
                                    <div class="form-group"></div>
                                </div>
                                {{-- <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="">
                                        <label for="create_profile">
                                            <input type="checkbox" name="create_profile" id="create_profile" {{old('create_profile')?'checked':''}} /> Tôi cũng muốn tạo profile
                                        </label>

                                    </div>
                                    <div class="form-group"></div>
                                </div> --}}
                                
                                
                            </div>
                            <div class="contact-section-btn text-center">
                                <div class="form-group style-two">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button class="theme-btn btn-style-one" type="submit" data-loading-text="Vui lòng chờ giây lát...">Đăng ký</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
                
                <!--Info Column-->
                <div class="column info-column col-md-4 col-sm-12 col-xs-12 pull-right">
                
                	<div class="default-title"><h3>Đăng nhập</h3><div class="separator"></div></div>
                    <div class="default-form-area">
                        <form id="login-form" name="login_form" class="login-form default-form" action="{{route('client.auth.login')}}" method="post" novalidate>
                            @csrf
                            <div class="row clearfix">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="text" name="username" class="form-control required" placeholder="Tài khoản" required="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group style-two">
                                        <input type="password" name="password" class="form-control required password" placeholder="Mật khẩu" required="">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="">
                                        <label for="remember">
                                            <input type="checkbox" name="remember" id="remember" /> Duy trì đăng nhập
                                        </label>

                                    </div>
                                    <div class="form-group"></div>
                                </div>
                                
                                
                            </div>
                            <div class="contact-section-btn text-center">
                                <div class="form-group style-two">
                                    <button class="theme-btn btn-style-one" type="submit" data-loading-text="Vui lòng chờ giây lát...">Đăng nhập</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script>
        $(()=>{
            $('#register-form input.error, #register-form textarea.error, #register-form select.error').on('focusin change click', function(){
                var errorId = $(this).attr('id')+'-error';
                $(this).removeClass('error');
                $('#'+errorId).hide(300, function(){
                    $(this).remove();
                });
            });
        });
    </script>
@endsection