<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$siteinfo->title;
?>

@extends($__layouts.'main')

@section('title', $title)

@section('content')

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> {{$title}}
                        @isset($back_link) 
                            <a href="{{$back_link}}" class="btm btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        @endisset
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> {{isset($form_title)?$form_title:$title}} </h3>
            </div>
            <form id="slider-form" method="POST" action="{{route('admin.slider.save')}}"  novalidate="true">
                    @csrf
                    <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $form->id)}}">
                   
                    <?php $inp = $inputs->name; ?>
                    <div class="form-group row {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                        <label for="{{$inp->id}}" class="form-control-label col-sm-3 col-lg-2" id="label-for-{{$inp->name}}">{{$inp->label}}</label>
                        <div class="input-{{$inp->type}}-wrapper col-sm-8 col-lg-10">
                            {!!$inp!!}
                            {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
                        </div>
                    </div>

                    <?php $inp = $inputs->position; ?>
                    <div class="form-group row {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                        <label for="{{$inp->id}}" class="form-control-label  col-sm-3 col-lg-2" id="label-for-{{$inp->name}}">{{$inp->label}}</label>
                        <div class="input-{{$inp->type}}-wrapper col-sm-8 col-lg-10">
                            {!!$inp!!}
                            {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
                        </div>
                    </div>


                    <?php $inp = $inputs->crop->removeClass('form-control'); ?>
                    <div class="form-group row {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                        <label for="{{$inp->id}}" class="form-control-label  col-sm-3 col-lg-2" id="label-for-{{$inp->name}}"></label>
                        <div class="input-{{$inp->type}}-wrapper col-sm-9 col-lg-10">
                            {!!$inp!!}
                            {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
                        </div>
                    </div>

                    <?php 
                    $inw = $inputs->width;
                    $inh = $inputs->height; 
                    ?>
                    
                    <div class="form-group row {{($inw->error||$inh->error)?'has-error':''}} d-none" id="form-group-size">
                        <label for="{{$inw->id}}" class="form-control-label col-5 col-sm-3 col-lg-2" id="label-for-{{$inw->name}}">Kích thức</label>
                        <div class="input-{{$inw->type}}-wrapper col-3 col-sm-3 col-lg-2">
                            {!!$inw!!}
                            {!! $inw->error?(HTML::span($inw->error,['class'=>'has-error'])):'' !!}
                        </div>
                        <div class="input-{{$inh->type}}-wrappe col-2 col-sm-3 col-lg-2">
                            {!!$inh!!}
                            {!! $inh->error?(HTML::span($inh->error,['class'=>'has-error'])):'' !!}
                        </div>
                    </div>

                    @if($inputs->priority)
                    <?php $inp = $inputs->priority; ?>
                    <div class="form-group row {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                        <label for="{{$inp->id}}" class="form-control-label col-5 col-sm-3 col-lg-2" id="label-for-{{$inp->name}}">{{$inp->label}}</label>
                        <div class="input-{{$inp->type}}-wrapper col-7 col-sm-8 col-lg-10">
                            {!!$inp!!}
                            {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-3 col-lg-2"></div>
                        <div class="col-sm-9 col-lg-10">
                            <button class="btn btn-primary" type="submit">{{$btnSaveText}}</button> 
                            <button class="btn btn-danger btn-cancel" type="button">Hủy</button>
                        </div>
                        
                    </div>
                    
                </form>
                
                
        </div>
    </div>


</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-select/css/bootstrap-select.css')}}" />

@endsection

@section('js')
    <script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    @include($__templates.'form-js')


@endsection