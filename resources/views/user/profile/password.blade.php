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
            <form method="POST" action="{{route('user.profile.setting.save-password')}}" id="setting-password-form" enctype="multipart/form-data" novalidate>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-8">
                        <!-- form group -->
                        @foreach(['current_password' => 'Mật khẩu hiện tại','new_password' => 'Mật khẩu mới','new_password_confirmation'=> 'Nhập lại mật khẩu mới'] as $f => $t)
                        <div class="form-group row {{$errors->has($f)?'has-error':''}}" id="form-group-{{$f}}">
                            <label for="{{$f}}" class="col-sm-3 form-control-label" id="label-for-{{$f}}">{{$t}}</label>
                            <div class="col-sm-9">
                                <input type="password" name="{{$f}}" id="{{$f}}" class=" form-control" placeholder="{{$t}}">
                                @if($errors->has($f))
                                <span class="has-error">{{$errors->first($f)}}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-8 text-center">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <button type="button" class="btn btn-cancel btn-danger">Hủy</button>
                    </div>
                </div>
                
            </form>


        </div>
    </div>
    
</article>

@endsection

@section('js')
<script>
    @if(session('alert'))
    modal_confirm('{{session('alert')}}<br>Bạn có muốn đăng xuất không?',function(e){
        if(e){
            top.location.href = '{{route('logout')}}';
        }
    });
    @endif
</script>
@endsection
