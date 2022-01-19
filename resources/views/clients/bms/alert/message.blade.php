@extends($__layouts.'single')

@section('title',"Thông báo")

@section('content')
<?php
    $type = (isset($type) && $type)?$type:(session('type')?session('type'):'success');
    $message = (isset($message) && $message)?$message:(session('message')?session('message'):'Hello World');
    
?>

    <!--Error Section-->
	<section class="error-section" style="margin-top: 80px; margin-bottom: 80px">
        <div class="container">
            <div class="content">
                <div class="alert alert-{{$type}} text-center">{!! $message !!}</div>
                <div class="buttons text-center" style="margin: 20px auto;">
                    <a href="{{route('home')}}" class="theme-btn btn-style-two"><i class="fa fa-home"></i> Về trang chủ</a>
                </div>
            </div>
        </div>
    </section>
    <!--Error Section-->
@endsection




