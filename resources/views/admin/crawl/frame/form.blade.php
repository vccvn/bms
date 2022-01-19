<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;

$fields = [
        "name",

        'url',
        
        "title",
        
        "image",
        
        "description",
        
        "tag",
        
        "content",
        "avatar",
        
        'except',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'index',
        'style',
        
        //"created_by"
    ];
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
                    <h3 class="title"> 
                        {{$title}}
                        
                    </h3>
                    
                </div>
            </div>
        </div>
        {{-- @include($__templates.'list-search',['search_url'=>route('admin.option.group',['option_group'=>$option_group])]) --}}
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> {{isset($form_title)?$form_title:$title}} </h3>
            </div>
            <form id="slider-item-form" method="POST" action="{{route('admin.crawler.frame.save')}}" enctype="multipart/form-data"  novalidate="true">
                @csrf
                <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $form->id)}}">
                @foreach($fields as $name)
                    @php 
                    $input = $inputs->get($name);
                    if(!$input) continue;
                    $t = $input->type;
                    $hasAttr = in_array($input->name,['title','image','description','tag']);
                    @endphp
                    @if($t=='hidden')
                        {!!$input!!}
                        <!-- {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!} -->
                    @else
                        <div class="form-group row {{$input->error?'has-error':''}}" id="form-group-{{$name}}">
                            <label for="{{$input->id}}" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 {{$input->required?'required':''}}" id="label-for-{{$name}}">{{$input->label}}</label>
                            <div class="input-{{$t}}-wrapper {{$hasAttr?'col-sm-5 col-md-6 col-lg-5 col-xl-6':'col-sm-8 col-md-9 col-lg-8 col-xl-9'}}">
                                @if($t=='image')
                                    <div class="input-group">
                                        <input class="input-file-fake form-control" readonly="true" type="text" name="image_show" value="{{$input->val()}}">
                                        <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                    </div>
                                @else
                                    {!!$input!!}
                                @endif
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            </div>
                            @if ($hasAttr && $attr = $inputs->get('attr_'.$name))
                                <div class="input-{{$t}}-wrapper col-sm-3">
                                    {!!$attr!!}
                                    {!! $attr->error?(HTML::span($attr->error,['class'=>'has-error'])):'' !!}
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-sm-4 col-lg-3"></div>
                    <div class="col-sm-8 col-lg-9">
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
    <style>
    label.required::after{
        content:"*";
        display: inline-block;
        color: #f00;
        margin-left: 5px;
        font-size: 1rem;
        line-height: 1.5;
    }
    </style>
@endsection

@section('js')

    @include($__templates.'form-js')

@endsection
