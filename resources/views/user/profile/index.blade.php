@extends('user.profile.layout')

@section('title', $profile->name)

@section('content')

@php 
$genders = ["Nam","Nữ"]; 
@endphp

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> {{$profile->name}} </h3>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card items profile-info">
    
        <div class="card card-block sameheight-item">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <p class="text-center">Avatar</p>
                    <p class="avatar-frame text-center"><img src="{{$profile->getAvatar()}}" alt="{{$profile->name}}"></p>
                    <h3 class="text-center">{{$profile->name}}</h3>
                </div>
                <div class="col-md-8 col-lg-9 user-info-list">
                    <h3>Thông tin cá nhân</h3>
                    <div class="row">
                        <div class="col-4">Họ tên</div>
                        <div class="col-8">{{$profile->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-4">Giới tính</div>
                        <div class="col-8">{{$genders[$profile->gender?$profile->gender:0]}}</div>
                    </div>
                    <div class="row">
                            <div class="col-4">Email</div>
                            <div class="col-8">{{$profile->email}}</div>
                        </div>
                        <div class="row">
                                <div class="col-4">Username</div>
                                <div class="col-8">{{$profile->username}}</div>
                            </div>
                            <div class="row">
                        <div class="col-4">Số điện thoại</div>
                        <div class="col-8">{{$profile->phone_number}}</div>
                    </div>
                    {{--  <div class="row">
                        <div class="col-4">Loại tài khoản</div>
                        <div class="col-8">{{$profile->isAdmin()?"Admin":($profile->isCollaborator()?"Cộng tác viên":"Thành viên")}}</div>
                    </div>  --}}
                    
                </div>
            </div>
        </div>
    </div>
    
</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('jsinit')
<script>
    // window.menusInit = function() {
    //     Cube.menus.init({
    //         urls:{
    //             delete_menu_url: '{{route('admin.menu.delete')}}'
    //         }
    //     });
    // };
</script>
@endsection