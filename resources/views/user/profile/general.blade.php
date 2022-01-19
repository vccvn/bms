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
            <form method="POST" action="{{route('user.profile.setting.save-general')}}" id="setting-general-form" enctype="multipart/form-data" novalidate>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-8">
                        <!-- form group -->
                        <div class="form-group row {{$errors->has('name')?'has-error':''}}" id="form-group-name">
                            <label for="name" class="col-sm-3 form-control-label" id="label-for-name">Họ và tên</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class=" form-control" placeholder="Họ và tên" value="{{old('name',$profile->name)}}">
                                @if($errors->has('name'))
                                <span class="has-error">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                        </div>
                        {{--  <!-- form group -->
                        <div class="form-group row {{$errors->has('gender')?'has-error':''}}" id="form-group-gender">
                            <label for="gender" class="col-sm-3 form-control-label" id="label-for-gender">Giới tính</label>
                            <div class="col-sm-9">
                                @php 
                                    $genders = ["Nam", "Nữ"];
                                    $g = old('gender',$profile->gender);
                                    foreach($genders as $v => $t){
                                        echo '<label class="pr-4"><input type="radio" name="gender" value="'.$v.'" '.($g==$v?'checked':'').'>  '.$t.'</label>';
                                    }
                                @endphp
                                @if($errors->has('gender'))
                                <span class="has-error">{{$errors->first('gender')}}</span>
                                @endif
                            </div>
                        </div>  --}}
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
