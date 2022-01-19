<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$types = ['province' => 'Tỉnh','city' => 'Thành Phố'];
?>


@extends($__layouts.'main')

@section('title', 'Tỉnh thành')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Tỉnh thành 
                        <a href="{{route('admin.province.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
    <div class="row">
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <div class="card items">
                @include('admin._templates.list-filter',[
                    'filter_list'=>[
                        'name' => 'Tên tỉnh thành'
                    ]
                ])
                @if($list->count()>0)
                <ul class="item-list striped list-body list-item">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="area-check">
                                    <input type="checkbox" class="checkbox check-all">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col item-col-header item-col-same-md item-col-title">
                                <div>
                                    <span>Tên tỉnh thành</span>
                                </div>
                            </div>
                            
                            <div class="item-col item-col-header item-col-same-sm">
                                <div>
                                    <span>Phân loại</span>
                                </div>
                            </div>
                            
                            <div class="item-col item-col-header item-col-same">
                                <div>
                                    <span>Slug</span>
                                </div>
                            </div>
                            
                            
                            <div class="item-col item-col-header fixed item-col-stats"> 
                                <span>actions</span>
                            </div>
                        </div>
                    </li>
                    @foreach($list as $item)
                    <li class="item" id="item-{{$item->id}}">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="comments[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed pull-left item-col-title item-col-same-md">
                                <div class="item-heading">Tên tỉnh thành</div>
                                <div>
                                    
                                    <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->name}}"> 
                                        <a href="{{$item->getUpdateUrl()}}" class="">{{$item->name}} </a>
                                    </h4>
                                        
                                    
                                </div>
                            </div>
                            
                            <div class="item-col item-col-same-sm no-overflow">
                                <div class="item-heading">Phân loại</div>
                                <div class="no-overflow">
                                    <span>{{$types[$item->type]}}</span>
                                </div>
                            </div>
                        
                            <div class="item-col item-col-same no-overflow">
                                <div class="item-heading">Slug</div>
                                <div class="no-overflow">
                                    <span>{{$item->slug}}</span>
                                </div>
                            </div>
                                
                            <div class="item-col fixed item-col-stats pull-right">
                                <div class="item-actions">
                                    <ul class="actions-list text-right">
                                        <li>
                                            <a href="{{$item->getUpdateUrl()}}" class="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}" title="xóa">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <div class="card card-block ">
                    <div class="row pt-4">
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
                </div>
                @else
                    <p class="alert alert-danger text-center">
                        Danh sách trống
                    </p>
                @endif
                
            </div>
        </div>

        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm Tỉnh / Thành Phố </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="{{route('admin.province.save')}}"  novalidate="true">
                        @csrf
        
                        @foreach($inputs->get() as $inp)
                        <div class="form-group {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                            @if(!in_array($inp->type,['radio','checkbox','checklist']))
                            <label for="{{$inp->id}}" class="form-control-label" id="label-for-{{$inp->name}}">{{$inp->label}}</label>
                            @else
                            <?php $inp->removeClass('form-control'); ?>
                            @endif
                            <div class="input-{{$inp->type}}-wrapper">
                                {!! $inp !!}
        
                                {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
        
                            </div>
                        </div>
                        @endforeach
        
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Thêm</button>
                        </div>
                    </form>        
                </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Nhập dữ liệu Tỉnh / Thành Phố </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="{{route('admin.province.import')}}" enctype="multipart/form-data"  novalidate="true">
                        @csrf
                        <div class="form-group form-input-file-group">
                            <div class="input-file-wrapper">
                                <div class="input-group">
                                    <input class="input-file-fake form-control" readonly="true" type="text" name="file_data_show" value="{{old('file_data')}}" placeholder="Chọn file">
                                    <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                </div>
                                <input type="file" name="file_data" id="file_data" class="input-hidden-file" accept=".json">
                                @if ($errors->has('file_data'))
                                    <span class="has-erroe">{{$errors->first('file_data')}}</span>
                                @endif
                            </div>
                        </div>

        
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Nhập</button>
                        </div>
                    </form>        
                </div>
            </div>

        </div>
    </div>
    
    
</article>

@endsection

@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.province.delete')}}'
            }
        });
    };
</script>
@endsection

@section('is')
@if (session('added'))
<script>
    modal_alert('{{session('added')}}');
</script>
@endif

@endsection