@extends($__layouts.'main')

@section('title', "Thẻ")

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Thẻ
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.content.tag'])
    </div>
    <!-- list content -->
    <div class="row">
        <div class="col-12 col-md-4 col-lg-12 col-xl-4">
            <div class="card">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Thêm thẻ </h3>
                    </div>
                    <form id="tag-form" method="POST" action="{{route('admin.content.tag.save')}}"  novalidate="true">
                        @csrf

                        <div class="form-group {{$errors->has('tag')?'has-error':''}}" id="form-group-tag">
                            <label for="input-tag" class="form-control-label" id="label-for-input-tag">Thẻ</label>
                            <div class="input-input-tags-wrapper input-group">
                                <input type="text" name="tag" id="input-tag" class="form-control">
                                <span class="input-group-btn input-group-append">
                                    <button class="btn btn-primary" type="submit">Thêm</button>
                                </span>
                            </div>
                            {!!$errors->has('tag')?'<span class="has-error">'.$errors->first('tag').'</span>':''!!}
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-12 col-xl-8">
            @if(count($list)>0)
            <div class="card items">
                
                <ul class="item-list striped list-body list-item">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="area-check">
                                    <input type="checkbox" class="checkbox check-all">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed item-col-check">
                                <span>ID</span>
                            </div>
                            <div class="item-col item-col-header item-col-same item-col-title">
                                <div>
                                    <span>Thẻ</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats item-col-same-sm">
                                <div class="no-overflow">
                                    <span>Được gán thẻ</span>
                                </div>
                            </div>

                            <div class="item-col item-col-header fixed item-col-stats item-col-same-sm">
                                <div class="text-center">Actions</div>
                            </div>
                        </div>
                    </li>
                    @foreach($list as $item)
                    <li class="item" id="item-{{$item->id}}">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="sliders[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed item-col-check">
                                <span>{{$item->id}}</span>
                            </div>
                            <div class="item-col fixed pull-left item-col-same item-col-title">
                                <div class="item-heading">Thẻ</div>
                                <div>
                                    <h4 class="item-title"> <a href="#" id="item-name-{{$item->id}}" class="btn-update-item" data-name="{{$item->keywords}}" data-id="{{$item->id}}">{{$item->keywords}}</a> </h4>
                                </div>
                            </div>
                            <div class="item-col item-col-stats item-col-same-sm  no-overflow">
                                <div class="item-heading">Số lần được gán thẻ</div>
                                <div class="no-overflow ">
                                    0
                                </div>
                            </div>
                            <div class="item-col fixed item-col-stats item-col-same-sm">
                                <div class="item-actions">
                                    <ul class="actions-list">
                                        <li>
                                            <a href="#" class="edit btn-update-item btn btn-sm btn-primary" data-id="{{$item->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="remove btn-delete-item btn btn-sm btn-danger" data-id="{{$item->id}}">
                                                <i class="fa fa-trash-o"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                
            </div>
            <div class="row pt-2 pb-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        {{$list->links('vendor.pagination.custom')}}
                    </nav>
                </div>
            </div>
            @else
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
            @endif
        </div>
        
    </div>
</article>

@endsection


@section('jsinit')
<?php 
    $templates = [
        'form' => '
            <div id="update-item-form">
                <div class="form-group row">
                    <label for="input-tags" class="form-control-label col-2">Thẻ</label>
                    <div class="input-wrapper col-10">
                        <input type="text" name="tag" id="input-tags" class="form-control" value="{$tag}" placeholder="Nhập thẻ">
                    </div>
                </div>
            </div>
        ',
        'message' => '
            <div id="update-item-message" class="d-none">
                <div class="alert alert-success message" id="update-item-message-text">{$message}</div>
            </div>
        ',
        'loading' => '
            <div id="forn-animate-loading" class="loader-block d-none">
                <div class="lds-ripple"><div></div><div></div></div>
            </div>
        ',
        'buttons' => [
            ['type'=>'button', 'className'=>'btn btn-primary btn-submit-update', 'text' =>'Cập nhật'],
            ['type'=>'button', 'className'=>'btn btn-primary btn-back-to-form d-none', 'text' =>'<i class="fa fa-arrow-left"></i> Quay lại']
        ]
    ];
?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.content.tag.delete')}}'
            }
        });
    };

    window.tagsInit = function() {
        Cube.tags.init({
            urls:{
                update_url: '{{route('admin.content.tag.update')}}',
                get_tag_url: '{{route('admin.content.tag.get')}}'
            },
            templates: {!! json_encode($templates) !!}
        });
    };
</script>
@endsection

@section('js')
<script src="{{asset('js/admin/tags.js')}}"></script>

@if(session('message'))
<script>
    modal_alert("{{session('message')}}");
</script>
@endif
@endsection

