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
                    <h3 class="title"> Công ty vận tải (Nhà xe)
                        <a href="{{route('admin.company.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        @include('admin._templates.search-filter',[
            'filter_list'=>[
                'name' => 'Tên nhà xe',
                'id' => 'Mã nhà xe',
                'phone_number' => 'Số điện thoại'
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
                    <div class="item-col fixed item-col-check">
                        <span>Mã</span>
                    </div>
                    <div class="item-col item-col-header item-col-same-md item-col-title">
                        <div>
                            <span>Tên nhà xe</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Số ĐT</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-md">
                        <div>
                            <span>Email</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same">
                        <div>
                            <span>Địa chỉ</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Số xe hoạt động</span>
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
                    <div class="item-col fixed item-col-check">
                        <span>{{$item->id}}</span>
                    </div>
                    <div class="item-col fixed pull-left item-col-title item-col-same-md">
                        <div class="item-heading">Tên bến xe</div>
                        <div>
                            
                            <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->name}}"> 
                                <a href="{{$item->getUpdateUrl()}}" class="">{{$item->name}} </a>
                            </h4>
                                
                            
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Số ĐT</div>
                        <div class="no-overflow">
                            <span>{{$item->phone_number}}</span>
                        </div>
                    </div>
                
                    <div class="item-col item-col-same-md no-overflow">
                        <div class="item-heading">Email</div>
                        <div class="no-overflow">
                            <span>{{$item->email}}</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same no-overflow">
                        <div class="item-heading">Địa chỉ</div>
                        <div class="no-overflow">
                            <span>{{$item->address}}</span>
                        </div>
                    </div>
                        
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Số xe đang hoạt động</div>
                        <div class="no-overflow">
                            <span>0</span>
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
                <div class="col-12 col-md-4">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-8">
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

</article>

@endsection

@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.company.delete')}}'
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