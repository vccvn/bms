@extends('admin.layouts.auth')

@section('title', $title)

@section('content')
@if(session('register'))
<div class="alert alert-success underline">
    {{session('register')}}
</div>

    <p class="text-center">Vui lòng đăng nhập để tiếp tục</p>


@endif
@if(session('error'))
<div class="alert alert-warning underline">
    {{session('error')}}
</div>
@endif

<form id="login-form" method="POST" action="{{route('login')}}" novalidate="true">
                
                {{csrf_field()}}
                
                <div class="form-group" id="form-group-username">
                	<label for="username" class="form-control-label" id="label-for-username">Tên đăng nhập</label>
                	<input type="text" name="username" id="username" class=" form-control underlined" placeholder="Tên đăng nhập" />
                </div>
                
                <div class="form-group" id="form-group-password">
                	<label for="password" class="form-control-label" id="label-for-password">Mật khẩu</label>
                	<input type="password" name="password" id="password" class=" form-control underlined" placeholder="Mật khẩu" />
                </div>
                <div class="form-group clearfix">
                	<label><input id="remember" class="checkbox" type="checkbox" name="remember" value="1" /> <span>Nhớ mật khẩu</span></label>
                	<a class="forgot-btn pull-right" href="{{route('forgot')}}">Quên mật khẩu</a></div><div class="form-group"><button class="btn btn-primary btn-block" type="submit">Save</button> </div><div class="form-group"><p class="text-muted text-center">Bạn chưa có tài khoản?
            <a href="http://localhost:81/register">Đăng ký mới</a></p></div>
            


@endsection

