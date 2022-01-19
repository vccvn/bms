<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:$siteinfo->title;
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
$form = new FormData($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):(isset($form_url)?$form_url:'');
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
            <div class="title-block">
                <h3 class="title">  </h3>
            </div>
            <form id="dynamic-form" method="POST" action="{{$fmact}}" enctype="multipart/form-data" novalidate="true">
                @csrf
                <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $model->id)}}">

                <div class="input-group-hidden" style="display: none">
                    <!-- 
                    {{$errors->first()}}
                    -->
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="text-center">Thông tin {{isset($post)?'chi tiết':"mục"}}</h3>
                        @foreach(['title','slug','description','content'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            @endphp
                            @if($name=='slug')
                                <?php if(!$inputs->custom_slug->val())$input->attr('readonly',"true");?>
                                <div class="form-group {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                    <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                    <div class="input-{{$input->type}}-wrapper">
                                        <div class="input-group input-slug">
                                            <div class="input-group-prepend input-group-addon">
                                                <label class="input-group-text mb-0" id="label-for-{{$input->name}}">
                                                    <input type="checkbox" name="custom_slug" id="custom_slug" class="checkbox" {{$inputs->custom_slug->val()?"checked=\"true\"":""}}>
                                                    <span>Tùy chỉnh</span>
                                                </label>
                                            </div>
                                            {!!$input!!}
                                            <div class="input-group-append input-group-addon"><span>.html</span></div>
                                        </div>
                                        {!! HTML::span($input->error,['class'=>'slug-message has-error slug-message']) !!}
                                    </div>
                                </div>
                            @else
                                <div class="form-group {{$name=='type'?"dev-only":""}} {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                    <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                    <div class="input-{{$input->type}}-wrapper">
                                        {!!$input!!}
                                        {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-5">
                        <h3 class="text-center">Hình minh họa</h3>
                        <div class="select-file image-editor">
                            <div class="cropit-preview"></div>
                            <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" />
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
                        <div class="form-group keep-original">
                            <label for="keep_original" class="form-control-label">
                                <input type="checkbox" name="keep_original" id="keep_original" {{old('keep_original', $model->keep_original)?"checked":''}}> Giữ nguyên kích thước
                            </label>
                        </div>
                        <div class="form-group keep-original">
                            {!! $inputs->show_thumbnail->removeClass('form-control') !!}
                        </div>
                        
                        @foreach(['parent_id','keywords'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            @endphp
                        

                        <div class="form-group {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                            @if($input->type!='checkbox')
                                <label for="{{$input->id}}" class="form-control-label" id="label-for-{{$input->name}}">{{$input->label}}</label>
                            @endif
                            <div class="input-{{$input->type}}-wrapper">
                                {!!$input!!}
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            </div>
                        </div>
                        @endforeach



                        <!-- link -->
                        <div class="card sameheight-item">

                            <?php 
                            $tag_templates = [
                                'list' => '<ul class="taglist">{$items}</ul>',
                                'item' => '<li class="tagitem" id="tag-item-{$id}"><a href="#" class="add-tag-item" data-id="{$id}" data-keywords="{$keywords}">{$keywords}</a></li>',
                                'hidden_input' => '<input type="hidden" name="tags[]" id="tag-hidden-{$id}" class="input-tag-hidden" value="{$id}">',
                                'link_item' => '<li id="taglink-item-{$id}" class="taglink-item">{$keywords} <a href="#" class="btn-remove-taglink" data-id="{$id}">x</a></li>',
                                'link_list' => '<ul class="tag-list-body">{$items}</ul>'
                            ];
                            ?>
                            <div class="product-links">
                                <!-- Nav tabs -->
                                <div class="card-title-block">
                                    <h3 class="title"> Mở rộng </h3>
                                </div>
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <a href="#tag-link" class="nav-link active" data-target="#tag-link" data-toggle="tab" aria-controls="product-linked" role="tab">Thẻ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#advanced-feature" class="nav-link" data-target="#advanced-feature" data-toggle="tab" aria-controls="product-linked" role="tab">Nâng cao</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabs-bordered">
                                    <div class="tab-pane fade in active show" id="tag-link">
                                        <h5>Thẻ</h5>
                                        @include($__templates.'add-tags-feature')
                                    </div>
                                    <div class="tab-pane fade in" id="advanced-feature">
                                        <h5>Các tùy chọn nâng cao</h5>
                                        <?php
                                            $props = [
                                                'title', 'slug', 'description','content', 
                                                'keywords', 'feature_image', 'tag','advance','product_link'];
                                        ?>
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                bao gồm các trường sau:
                                            </label>
                                            <div class="inputs">
                                                @foreach($props as $p)
                                                    <label class="d-inline-block ml-3">
                                                        <input type="checkbox" name="required_fields[]" value="{{$p}}" {{(in_array($p, $required_fields) || old('required_fields.'.$p))?'checked="true" ':''}} /> {{$p}}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        @foreach(['post_type','allow_comment','use_category', 'children_props'] as $name)
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
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-block -->
                        </div>
                        <!-- /.card -->
                        

                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">{{$btnSaveText}}</button> 
                            <button class="btn btn-danger" type="button">Hủy</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                </div>

            </form>
            
                
        </div>
    </div>


</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('css/image-editor.css')}}" />
    <style>
    .image-editor, .keep-original {
        width: 400px;
        margin: 0 auto;
        position: relative;
    }
    .cropit-preview {
        /* You can specify preview size in CSS */
        width: 400px;
        height: 240px;
    }
    </style>
@endsection

@section('jsinit')
<script>
    window.slugsInit = function() {
        Cube.slugs.init({
            input_selector:"input#title",
            urls:{
                get: '{{route('admin.dynamic.get-slug')}}',
                check: '{{route('admin.dynamic.check-slug')}}'
            }
        });
    };
    
    window.tagsInit = function() {
        Cube.tags.init({
            urls:{
                data_url: '{{route('admin.content.tag.data')}}',
                get_tag_url: '{{route('admin.content.tag.get')}}',
                add_tag_url: '{{route('admin.content.tag.ajax-add')}}'
            },
            templates: {!! json_encode($tag_templates) !!},
            search_selector:'#input-tag-link'
        });
    };
</script>
@endsection

@section('js')
    <script src="{{asset('js/admin/tags.js')}}"></script>
    <script src="{{asset('js/admin/image-editor.js')}}"></script>
    @include($__templates.'form-js')
    <script>
        startImageEditor("#dynamic-form", "{{asset('contents/dynamics/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))}}");
        
    </script>

@endsection