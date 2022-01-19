<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:"cubeAdmin";
$fd = isset($formdata)?$formdata:null;
$fmact = isset($form_action)?route($form_action):'';
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
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
                    <h3 class="title"> {{isset($form_title)?$form_title:$title}}
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
            <form id="category-form" method="POST" action="{{$fmact}}" enctype="multipart/form-data" novalidate="true">
                @csrf
                <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $model->id)}}">
                
                <div class="input-group-hidden" style="display: none">
                    
                    
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <h4 class="text-center">Chi tiết</h4>
                        @foreach(['name','description', 'parent_id'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            @endphp
                            <div class="form-group {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                <div class="input-{{$input->type}}-wrapper">
                                    {!!$input!!}
                                    {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="props-block mt-2">
                            <h4>Thuộc tính</h4>
                            @if($pps = $model->getParentProps())
                                <div class="parent-props">
                                    <span>Được kế thừa: </span>
                                    @foreach($pps as $p)
                                        {{$loop->index > 0? ', ':''}}
                                        {{"$p->name($p->label): $p->type"}}
                                    @endforeach
                                </div>
                            @endif

                            <div class="props-table">
                                <div class="table-header d-none d-md-block">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-3">
                                            Tên thuộc tính
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            Nhãn
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            Kiểu
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            Mặc định
                                        </div>
                                    </div>
                                </div>
                                <div class="table-body">
                                    <div id="prop-1" class="row">
                                        <div class="col-sm-6 col-md-3 col-prop-name">
                                            <input type="text" name="props[1][name]" id="prop-1-name" class="form-control" placeholder="Tên. vd: color">
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-prop-label">
                                            <input type="text" name="props[1][label]" id="prop-1-label" class="form-control" placeholder="Nhãn. vd: màu sắc">
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-prop-type">
                                            <select name="props[1][type]" id="prop-1-type" class="form-control">
                                                <option value="text">text</option>
                                                <option value="number">text</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-3 col-prop-default">
                                            Mặc định
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <h4 class="text-center">Hình minh họa</h4>
                            <div class="select-file image-editor">
                                <div class="cropit-preview"></div>
                                {{-- <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" /> --}}
                                <input type="hidden" name="image_data" class="hidden-image-data" />
                                <div class="change-icon-wrapper">
                                    <div class="file-select">
                                        <div class="choose-icon">
                                            <i class="fa fa-camera"></i> Chọn ảnh
                                        </div>
                                        <input type="file" name="feature_image" class="cropit-image-input" id="feature_image" accept="image/jpeg,image/png,image/gif">
                                    </div>
                                </div>
                            </div>
                            <div class="message text-danger text-center">
                                {!! $inputs->feature_image->error?(HTML::span($inputs->feature_image->error,['class'=>'has-error'])):'' !!}
                            </div>
                            
                        </div>
                        @foreach(['keywords', 'is_menu'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            @endphp
                            <div class="form-group {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                @if($input->type!='checkbox')
                                <label for="{{$input->id}}" class="form-control-label" id="label-for-{{$input->name}}">{{$input->label}}</label>
                                @endif
                                <div class="input-{{$input->type}}-wrapper">
                                    {!!$input!!}
                                    {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                </div>
                            </div>
                        
                        @endforeach
                        
                        

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">{{$btnSaveText}}</button> 
                            <button class="btn btn-danger" type="button">Hủy</button>
                        </div>
                    </div>
                </div>
                <div class="row"></div>
            </form>
        </div>
    </div>
</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/image-editor.css')}}" />
    <style>
    .image-editor, .keep-original  {
        width: 400px;
        margin: 0 auto;
        position: relative;
    }

    .cropit-preview {
        /* You can specify preview size in CSS */
        width: 400px;
        height: 600px;
    }


    </style>
@endsection

@section('jsinit')
<script>
    
</script>
@endsection

@section('js')
    <script src="{{asset('js/admin/tags.js')}}"></script>
    <script src="{{asset('js/admin/image-editor.js')}}"></script>

    @include($__templates.'form-js')

    <script>
        startImageEditor("#category-form", "{{asset('contents/categories/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.jpg'))}}");
    </script>


@endsection