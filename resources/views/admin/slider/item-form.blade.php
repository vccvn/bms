<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;
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
                    <h3 class="title"> <a href="{{$slider->getDetailUrl()}}">{{$title}}</a>
                        
                        <a href="{{$slider->getDetailUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        
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
            <form id="slider-item-form" method="POST" action="{{route('admin.slider.item.save')}}" enctype="multipart/form-data"  novalidate="true">
                @csrf
                <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $form->id)}}">
                @foreach($fieldList as $name)
                    @php 
                    $input = $inputs->get($name);
                    $t = $input->type;
                    @endphp
                    @if($t=='hidden')
                        {!!$input!!}
                        <!-- {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!} -->
                    @elseif($name!='image')
                    <div class="form-group row {{$input->error?'has-error':''}}" id="form-group-{{$name}}">
                            <label for="{{$input->id}}" class="form-control-label col-sm-3 col-md-2 col-lg-3 col-xl-2" id="label-for-{{$name}}">{{$input->label}}</label>
                            <div class="input-{{$t}}-wrapper col-sm-9 col-md-10 col-lg-9 col-xl-10">
                                {!!$input!!}
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            </div>
                        </div>
                    @else
                    <div class="form-group form-input-{{$t}}-group row {{$input->error?'has-error':''}}" id="form-group-{{$name}}">
                        <label for="{{$input->id}}" class="form-control-label col-sm-3 col-md-2 col-lg-3 col-xl-2" id="label-for-{{$name}}">{{$input->label}}</label>
                        <div class="input-{{$t}}-wrapper col-sm-9 col-md-10 col-lg-9 col-xl-10">
                            @if($slider->crop)
                            <div class="select-file image-editor">
                                <div class="cropit-preview"></div>
                                <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" />
                                <input type="hidden" name="image_data" class="hidden-image-data" />
                                <div class="change-icon-wrapper">
                                    <div class="file-select">
                                        <div class="choose-icon">
                                            <i class="fa fa-camera"></i> Chọn ảnh
                                        </div>
                                        <input type="file" name="image" class="cropit-image-input" id="image" accept="image/jpeg,image/png,image/gif">
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="input-group">
                                    <input class="input-file-fake form-control" readonly="true" type="text" name="image_show" value="{{$input->val()}}">
                                    <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                </div>
                                
                                {!!$input->addClass('input-hidden-file')!!}
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
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
@if($slider->crop)
    
    @section('js')
        <script>
            $(function() {
                function saveImageData(){
                    var imageData = $('.image-editor').cropit('export');
                    $('.hidden-image-data').val(imageData);
                };
                $('.image-editor').cropit({ 
                    imageState: { 
                        src:  "{{asset('contents/sliders/'.(($inputs->image && $inputs->image->val())?$inputs->image->value:'default.png'))}}"
                    },
                    smallImage:'allow',
                    onFileChange:function() {
                        setTimeout(saveImageData,100);
                    }
                });

                $('.cropit-image-zoom-input').change(function() {
                    setTimeout(saveImageData,100);
                });
                $('#slider-item-form').submit(function() {
                    saveImageData();
                    return true;
                });
            });
        </script>
    @endsection

    @section('css')
    <link rel="stylesheet" href="{{asset('css/image-editor.css')}}" />
    <style>
    .image-editor {
        width: {{$slider->width}}px;
        margin: 0 auto;
        position: relative;
    }

    .cropit-preview {
        /* You can specify preview size in CSS */
        width: {{$slider->width}}px;
        height: {{$slider->height}}px;
    }


    </style>
    
    @endsection

@endif