<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;

$title = isset($title)?$title:"cubeAdmin";
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
$form = new Cube\Arr($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):'';

$inputs = new Inputs($formJSON,$fieldList, $fd, $errors);

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
            {{$inputs->name}}
                
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