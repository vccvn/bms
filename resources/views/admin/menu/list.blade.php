<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>

@extends($__layouts.'main')

@section('title', 'Menu')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Menu
                        <a href="{{route('admin.menu.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.menu.list'])
    </div>

    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm menu </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="menu-form" method="POST" action="{{route('admin.menu.save')}}"  novalidate="true">
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

        </div>
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            
            <!-- list content -->
            @if($list->count()>0)
            <div class="card items">
                
                <ul class="item-list striped list-body list-menu">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="area-check">
                                    <input type="checkbox" class="checkbox check-all">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col item-col-header item-col-title item-col-same">
                                <div>
                                    <span>Tên</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Loại</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Menu chính</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Thứ tự</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-same-sm fixed item-col-actions-dropdown"> </div>
                        </div>
                    </li>
                    @foreach($list as $item)
                    <li class="item" id="menu-{{$item->id}}">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="menus[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed pull-left item-col-title item-col-same">
                                <div class="item-heading">Tên</div>
                                <div>
                                    <a href="{{$item->type=='default'?$item->getDetailUrl():$item->getUpdateUrl()}}" class="">
                                        <h4 class="item-title"> {{$item->name}} </h4>
                                    </a>
                                </div>
                            </div>
                            <div class="item-col item-col-stats no-overflow">
                                <div class="item-heading">Loại</div>
                                <div class="no-overflow">
                                    {{$item->type}}
                                </div>
                            </div>
                            <div class="item-col item-col-stats no-overflow">
                                <div class="item-heading">Loại</div>
                                <div class="no-overflow">
                                    {{$item->active?"Có":"Không"}}
                                </div>
                            </div>
                            <div class="item-col item-col-stats">
                                <div class="item-heading">Thứ tự</div>
                                <div>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{$item->priority}}
                                        </button>
                                        {!!
                                            (new Cube\Html\Menu([
                                                    'type'=>'list',
                                                    'data'=>$item->getPriorityMenuList()
                                                ],[
                                                    'menu_id' => 'dropdown-item-'.$item->id,
                                                    'menu_class' => 'dropdown-menu',
                                                    'menu_tag' => 'div',
                                                    'item_tag' => null,
                                                    'link_class' => 'dropdown-item nav-link pt-2 pb-2'
                                                ],
                                                'action-'.$item->id
                                                )
                                            )->render(function($curent){
                                                $curent->link->href='#';
                                                if($curent->isLast()){
                                                    $curent->link->before('<div class="dropdown-divider"></div>');
                                                }
                                            })
                                        !!}
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="item-col fixed item-col-actions-dropdown item-col-same-sm">
                                <div class="item-actions">
                                    <ul class="actions-list">
                                        <li>
                                            <a href="{{$item->getUpdateUrl()}}" class="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="remove btn-delete-menu" data-id="{{$item->id}}">
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
            <div class="row pt-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-menu"><i class="fa fa-trash"></i></a>
                    
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
<script>
    window.menusInit = function() {
        Cube.menus.init({
            urls:{
                delete_menu_url: '{{route('admin.menu.delete')}}'
            }
        });
    };
</script>
@endsection