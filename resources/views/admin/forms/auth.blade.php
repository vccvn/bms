<?php
if(isset($formdata)){
	$fd = $formdata;
}
else{
	$fd = null;
}
$form = new Cube\Arr($fd); //tao mang du lieu
$title = isset($title)?$title:"cubeAdmin";

$ft = isset($form_type)?$form_type:$form_action;
$inputs = Cube\HtmlInput::getInputList($formJSON,$fieldList);
?>
@extends('admin.layouts.auth')

@section('title', $title)

@section('content')



<p class="text-center">{{$title}}</p>
@if(session('register'))
<div class="alert alert-success underline">
    {{session('register')}}
</div>
@endif
			
@if(session('error'))
<div class="alert alert-warning underline">
    {{session('error')}}
</div>
@endif
			
<form method="POST" enctype="multipart/form-data" action="@isset($form_action){{route($form_action)}}@endisset" novalidate>
{{ csrf_field() }}
@foreach($inputs as $input)
    <?php $t = $input->type; ?>
    @if($input->type=='hidden')
    <input type="hidden" name="{{$input->name}}" id="{{$input->name}}" value="{{$form->get($input->name)}}">
    @else
    <div class="form-group {{$errors->has($input->name)?'has-error':''}}">
        <label for="{{$input->name}}" class="form-control-label">{{$input->text}}</label>
        <div class="">
        
        <?php
            $input->type = ($t=="date" || $t=="time" || $t=="datetime")?"text":$input->type;
            $input->value = $input->type=='password'? '':( old($input->name) ? old($input->name) : $form->get($input->name) );
            $input->id = $input->name;
            $input->addClass("inp-$t underlined ".(
                $input->type!='checkbox' && $input->type!='radio'?"form-control ":""
            ).(
                $errors->has($input->name)?'has-error':''
            ));
            
            $input->props['placeholder'] = $input->text;
        ?>

        {!! $input->render() !!}
        @if($errors->has($input->name))
            <span class="has-error">{{$errors->first($input->name)}}</span>
        @endif

        </div>
    </div>
    @endif
@endforeach
@if($ft=='register')
    <div class="form-group {{$errors->has("agree")?'has-error':''}}">
        <label for="agree">
            <input class="checkbox" name="agree" id="agree" type="checkbox" required="">
            <span>T??i ?????ng ?? v???i 
                <a href="#">C??c di???u kho???n</a>
            </span>
            @if($errors->has("agree"))
                <span class="has-error">{{$errors->first("agree")}}</span>
            @endif
        </label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">????ng k??</button>
    </div>

    <div class="form-group">
        <p class="text-muted text-center">???? c?? t??i kho???n?
            <a href="{{route('login')}}">????ng ng???p</a>
        </p>
    </div>
@elseif($ft=='login')
    <div class="form-group">
        <label for="remember">
            <input class="checkbox" name="remember" id="remember" type="checkbox">
            <span>Nh??? m???t kh???u</span>
        </label>
        <a href="{{route('forgot')}}" class="forgot-btn pull-right">Qu??n m???t kh???u?</a>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary">????ng nh???p</button>
    </div>
    <div class="form-group">
        <p class="text-muted text-center">B???n ch??a c?? t??i kho???n
            <a href="{{route('register')}}">????ng k??</a>
        </p>
    </div>
@else
    <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary">L???y l???i m???t kh???u</button>
    </div>
    <div class="form-group clearfix">
        <a class="pull-left" href="{{route('login')}}">Tr??? l???i trang ????ng nh???p</a>
        <a class="pull-right" href="{{route('register')}}">????ng k?? m???i</a>
    </div>

@endif
</form>



@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />

{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css" />  --}}
@endsection

@section('js')
    
	<script src="{{asset('plugins/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('plugins/datetimepicker/bootstrap.js')}}"></script>
<script>
$(document).ready(function() {

    if ($('input.inp-date')) {
        $('.inp-date').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD'
        });
    }
    if ($('input.inp-time')) {
        $('.inp-time').datetimepicker({
            locale: 'vi',
            format: 'HH:ii:ss'
        });
    }
    if ($('input.inp-datetime')) {
        $('.inp-datetime').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    }
	//default date range picker
    
});

</script>

@endsection