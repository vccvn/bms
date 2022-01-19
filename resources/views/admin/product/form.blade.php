<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
$title = isset($title)?$title:$siteinfo->title;
$fd = isset($formdata)?$formdata:null; // form data
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
            <div class="title-block">
                <h3 class="title">  </h3>
            </div>
            <form id="product-form" method="POST" action="{{$fmact}}" enctype="multipart/form-data" novalidate="true">
                @csrf
                <input type="hidden" name="id" value="{{old('id', $model->id)}}">
                <div class="input-group-hidden" style="display: none">
                    @if($model->gallery)
                        @foreach($model->gallery as $ga)
                            <input type="hidden" name="gallery_list[]" id="gallery-hidden-{{$ga->id}}" class="input-gallery-hidden" value="{{$ga->id}}" />
                        @endforeach
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-xl-7">
                        <div class="props-form">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-pills">
                                <li class="nav-item">
                                    <a href="#info-tab" class="nav-link active" data-target="#info-tab" data-toggle="tab" aria-controls="props-form" role="tab">Thông tin </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#props-tab" class="nav-link" data-target="#props-tab" data-toggle="tab" aria-controls="props-form" role="tab">Thuộc tính &amp; SEO</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active show" id="info-tab">
                                    <h4 class="mt-3">Thông tin sản phẩm</h4>
                                    @foreach($fieldList as $name)
                                        @php 
                                        if(in_array($name, ['feature_image','keywords', 'description','gallery_images','sale_price', 'total','code'])) continue;
                                        $input = $inputs->get($name); 
                                        if(!$input){
                                            echo '<!-- '.$name.' loi sml -->';
                                            continue;
                                        }
                                        $is_number = $input->type == 'number';
                                        if(in_array($input->name,['sale_price','list_price'])){
                                            if(is_numeric($input->value)){
                                                $input->value = round($input->value);
                                            }
                                        }
                                        @endphp
                                        <div class="form-group {{$is_number?'row':''}} {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                            <label for="{{$input->id}}" class="form-control-label {{$is_number?'col-sm-5':''}}" id="label-for-{{$input->name}}">{{$input->label}}</label>
                                            <div class="input-{{$input->type}}-wrapper {{$is_number?'col-sm-7':''}}">
                                                {!!$input!!}
                                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                            </div>
                                        </div>
                                    
                                    @endforeach

                                    <div class="library mb-4">
                                        <h4 class="text-center">Thư viện ảnh</h4>
                                        <?php
                                            $input = $inputs->gallery_images;
                                            
                                        ?>
                                        <div class="form-group required {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                            <div class="input-{{$input->type}}-wrapper">
                                                <?php
                                                    $input->name.='[]';
                                                ?>
                                                {!!$input!!}
                                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                                <div class="uploader-preview-frame" style="display:{{count($model->gallery)?'block':'none'}};">
                                                    <h4>Xem trước</h4>
                                                    <div class="uploader-preview">
                                                        @if($model->gallery)
                                                            @foreach($model->gallery as $ga)
                                                            <div id="upload-item-{{$ga->id}}" class="upload-preview-item " title="{{$ga->original_filename}}">
                                                                <a class="btn-delete btn-delete-uploaded-item" href="#" data-id="{{$ga->id}}">X</a>
                                                                <img class="upload-preview-item-image" src="{{$ga->getUrl()}}">
                                                            </div>
                                                            @endforeach
                                                        @endif

                                                        
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="props-tab">
                                    <h4 class="mt-3">Thuộc tính sản phẩm</h4>

                                    @foreach(['code'] as $name)
                                    @php 
                                    $input = $inputs->get($name);
                                    if(!$input) continue;
                                    if(in_array($input->type,['radio','checkbox','checklist'])){
                                        $input->removeClass('form-control');
                                    }
                                    $is_number = $input->type == 'number';
                                    
                                    @endphp
                                    <div class="form-group {{$is_number?'row':''}} {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                        <label for="{{$input->id}}" class="form-control-label {{$is_number?'col-sm-5':''}}" id="label-for-{{$input->name}}">{{$input->label}}</label>
                                        <div class="input-{{$input->type}}-wrapper {{$is_number?'col-sm-7':''}}">
                                            {!!$input!!}
                                            {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                        </div>
                                    </div>
                                
                                    @endforeach
                                    
                                    <h4 class="mt-3">SEO</h4>
                                    @foreach(['description','keywords'] as $name)
                                    @php 
                                    $input = $inputs->get($name);
                                    if(!$input) continue;
                                    if(in_array($input->type,['radio','checkbox','checklist'])){
                                        $input->removeClass('form-control');
                                    }
                                    $is_number = $input->type == 'number';
                                    @endphp
                                    <div class="form-group {{$is_number?'row':''}} {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                        <label for="{{$input->id}}" class="form-control-label {{$is_number?'col-sm-5':''}}" id="label-for-{{$input->name}}">{{$input->label}}</label>
                                        <div class="input-{{$input->type}}-wrapper {{$is_number?'col-sm-7':''}}">
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
                                        <label>Thẻ</label>
                                        @include($__templates.'add-tags-feature')
                                        <!-- /.card-block -->
                                    </div>
                                    <!-- /.card -->
                                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-5">
                        <h3 class="text-center">Ảnh đại diện sản phẩm</h3>
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
                        <div class="form-group keep-original mb-4">
                            <label for="keep_original" class="form-control-label "><input type="checkbox" name="keep_original" id="keep_original" {{old('keep_original')?"checked":''}}> Giữ nguyên kích thước</label>
                        </div>
                        
                        {{-- @foreach(['sale_price', 'total'] as $name)
                        @php 
                        $input = $inputs->get($name);
                        if(!$input) continue;
                        if(in_array($input->type,['radio','checkbox','checklist'])){
                            $input->removeClass('form-control');
                        }
                        $is_number = $input->type == 'number';
                        if(in_array($input->name,['sale_price','list_price'])){
                            if(is_numeric($input->value)){
                                $input->value = round($input->value);
                            }
                        }
                        
                        @endphp
                        <div class="form-group {{$is_number?'row':''}} {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                            <label for="{{$input->id}}" class="form-control-label {{$is_number?'col-sm-5':''}}" id="label-for-{{$input->name}}">{{$input->label}}</label>
                            <div class="input-{{$input->type}}-wrapper {{$is_number?'col-sm-7':''}}">
                                {!!$input!!}
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            </div>
                        </div>
                    
                        @endforeach --}}
                        
                        
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
        height: 300px;
    }


    </style>
    

@endsection
@section('jsinit')
<script>
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
        
        $(function() {
            startImageEditor("#product-form", "{{asset('contents/products/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))}}");
            Cube.uploader.addForm('#product-form', 'gallery_images[]');

        });
    </script>


@endsection