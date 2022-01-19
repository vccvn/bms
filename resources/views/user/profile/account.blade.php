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
            <form method="POST" action="{{route('user.profile.setting.save-account')}}" id="setting-account-form" enctype="multipart/form-data" novalidate>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-8">
                        <!-- form group -->
                        @foreach(['username' => 'Tên truy cập','email' => 'Địa chỉ Email'] as $f => $t)
                        <div class="form-group row {{$errors->has($f)?'has-error':''}}" id="form-group-{{$f}}">
                            <label for="{{$f}}" class="col-sm-3 form-control-label" id="label-for-{{$f}}">{{$t}}</label>
                            <div class="col-sm-9">
                                <input type="{{$f=='email'?$f:'text'}}" name="{{$f}}" id="{{$f}}" class=" form-control" placeholder="{{$t}}" value="{{old($f,$profile->$f)}}">
                                @if($errors->has($f))
                                <span class="has-error">{{$errors->first($f)}}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row {{$errors->has('password')?'has-error':''}}" id="form-group-name">
                            <label for="password" class="col-sm-3 form-control-label" id="label-for-password">Mật khẩu hiện tại</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="password" class=" form-control" placeholder="Mật khẩu hiện tại">
                                @if($errors->has('password'))
                                <span class="has-error">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                        </div>
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
    modal_alert('{{session('alert')}}');
    @endif
</script>
@endsection
