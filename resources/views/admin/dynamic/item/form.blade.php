<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$title = isset($title)?$title:$siteinfo->title;
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
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
                    @if($model->gallery)
                        @foreach($model->gallery as $ga)
                            <input type="hidden" name="gallery_list[]" id="gallery-hidden-{{$ga->id}}" class="input-gallery-hidden" value="{{$ga->id}}" />
                        @endforeach
                    @endif

                    @if($model->productLinks)
                        @foreach($model->productLinks as $link)
                            <input type="hidden" name="products[]" id="product-hidden-{{$link->product_id}}" class="input-product-hidden" value="{{$link->product_id}}">
                        @endforeach
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        @if($props = $post->getChildrenPropInputData())
                        @include($__current.'props', compact('props', 'inputs', 'required_fields'))
                        @else
                        @include($__current.'non-props',compact('inputs', 'required_fields'))
                        @endif
                    </div>
                    <div class="col-md-5">
                        @if(in_array('feature_image', $required_fields))
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
                            <label for="keep_original" class="form-control-label ">
                                <input type="checkbox" name="keep_original" id="keep_original" {{old('keep_original', $model->keep_original)?"checked":''}}> Giữ nguyên kích thước
                            </label>
                        </div>
                        <div class="form-group keep-original">
                            {!! $inputs->show_thumbnail->removeClass('form-control') !!}
                        </div>
                        @endif
                        @foreach(['cate_id','keywords'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input || !in_array($input->name, $required_fields)) continue;
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
                        <?php 

                        $tag_templates = [
                            'list' => '<ul class="taglist">{$items}</ul>',
                            'item' => '<li class="tagitem" id="tag-item-{$id}"><a href="#" class="add-tag-item" data-id="{$id}" data-keywords="{$keywords}">{$keywords}</a></li>',
                            'hidden_input' => '<input type="hidden" name="tags[]" id="tag-hidden-{$id}" class="input-tag-hidden" value="{$id}">',
                            'link_item' => '<li id="taglink-item-{$id}" class="taglink-item">{$keywords} <a href="#" class="btn-remove-taglink" data-id="{$id}">x</a></li>',
                            'link_list' => '<ul class="tag-list-body">{$items}</ul>'
                        ];
                        $t = in_array('tag',$required_fields);
                        $hasProductLink = in_array('product_link',$required_fields);
                        if($hasProductLink){
                            $templates = [
                                // link-item search
                                'product_item' => '
                                    <div class="produvt-link-item" id="product-link-{$id}">
                                        {$name} 
                                        <a href="javascript:void(0)" class="btn-delete-product-item" data-id="{$id}">x</a>
                                    </div>',
                                
                                'product_list' => '
                                    <div class="produvt-link-list">{$items}</div>
                                ',
                                
                                'search_result' => '
                                    <div class="product-search-item" id="search-result-item-{$id}">
                                        <div class="check-block">
                                            <label class="item-block">
                                                <input type="checkbox" name="product[]" class="check-item checkbox" data-id="{$id}" value="{$id}">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="product-detail-block">
                                            <h5 class="product-name">{$name}</h5>
                                        </div>
                                        <div class="btn-block">
                                            <button type="button" class="btn btn-sm btn-primary btn-add-product-link" data-id="{$id}">Thêm</button>
                                        </div>
                                    </div>
                                ',
                                'search_list' => '
                                    <div class="search-result-list">
                                        <div class="product-search-item row-header">
                                            <div class="check-block">
                                                <label class="item-block">
                                                    <input type="checkbox" name="checkall" class="check-all checkbox" data-id="{$id}" value="{$id}">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="product-detail-block">
                                                <h5 class="title">Tên sãn phẩm</h5>
                                            </div>
                                            <div class="btn-block">
                                                <button type="button" class="btn btn-sm btn-warning btn-add-all-product-link">Thêm</button>
                                            </div>
                                        </div>
                                        <div class="list-body">
                                            {$results}
                                        </div>
                                        <div class="product-search-item row-footer">
                                            <div class="check-block">
                                                
                                            </div>
                                            <div class="product-detail-block">
                                                <p>{$total} sản phẩm</p>
                                            </div>
                                            <div class="btn-block">
                                                <button type="button" class="btn btn-sm btn-warning btn-add-all-product-link">Thêm</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                ',
                                
                                // linked
                                'linked_item' => '
                                    <div class="product-search-item" id="product-linked-item-{$id}">
                                        <div class="check-block">
                                            <label class="item-block">
                                                <input type="checkbox" name="product[]" class="check-item checkbox" data-id="{$id}" value="{$id}">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="product-detail-block">
                                            <h5>{$name}</h5>
                                        </div>
                                        <div class="btn-block">
                                            <button type="button" class="btn btn-sm btn-warning btn-delete-product-link" data-id="{$id}">Xóa</button>
                                        </div>
                                    </div>
                                ',
                                'linked_list' => '
                                    <div class="product-linked-list">
                                        <div class="product-search-item row-header">
                                            <div class="check-block">
                                                <label class="item-block">
                                                    <input type="checkbox" name="checkall" class="check-all checkbox" data-id="{$id}" value="{$id}">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="product-detail-block">
                                                <h5 class="title">Tên sãn phẩm</h5>
                                            </div>
                                            <div class="btn-block">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-all-product-link">Xóa</button>
                                            </div>
                                        </div>
                                        <div class="list-body">
                                            {$links}
                                        </div>
                                        <div class="product-search-item row-footer">
                                            <div class="check-block">
                                                
                                            </div>
                                            <div class="product-detail-block">
                                                <p><span class="total-product">{$total}</span> sản phẩm</p>
                                            </div>
                                            <div class="btn-block">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-all-product-link">Xóa</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                ',
                                
                                'message' => '
                                    <div class="search-message text-center">{$message}</div>
                                ',
                                'hidden_product_input' => '<input type="hidden" name="products[]" id="product-hidden-{$id}" class="input-product-hidden" value="{$id}">'
                            ];
                        }
                        ?>
                        @include($__current.'advance')
                        
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
    @if(in_array('slug', $required_fields))
    window.slugsInit = function() {
        Cube.slugs.init({
            input_selector:"input#title",
            urls:{
                get: '{{route('admin.dynamic.get-slug')}}',
                check: '{{route('admin.dynamic.check-slug')}}'
            }
        });
    };
    @endif
    @if(in_array('tag', $required_fields))
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
    @endif

    @if($hasProductLink)
    <?php
    $templates = json_encode($templates);
    ?>
    window.postsInit = function() {
        Cube.posts.init({
            urls:{
                search_product_url: '{{route('admin.post.product-links-data')}}'
            },
            templates: {!! $templates !!}
        });
    };
    @endif
</script>
@endsection

@section('js')
    @if(in_array('tag', $required_fields))
        <script src="{{asset('js/admin/tags.js')}}"></script>
    @endif
    @if(in_array('feature_image', $required_fields))
        <script src="{{asset('js/admin/image-editor.js')}}"></script>
    @endif
    @include($__templates.'form-js')
    @if(in_array('feature_image', $required_fields))
    <script>
        startImageEditor("#dynamic-form", "{{asset('contents/dynamics/'.(($inputs->feature_image && $inputs->feature_image->val())?$inputs->feature_image->value:'default.png'))}}");
    </script>
    @endif
    @if($post->post_type=='gallery')
    <script type="text/javascript">
        Cube.uploader.addForm('#dynamic-form', 'gallery_images[]');
    </script>
    @endif


@endsection