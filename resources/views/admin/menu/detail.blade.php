@extends($__layouts.'main')

@section('title', 'Menu; '.$detail->name)

@section('content')


<article class="content items-list-page" id="menu-{{$detail->id}}">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> {{$detail->name}}
                        <a href="{{$detail->getUpdateUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete-menu" data-id="{{$detail->id}}"><i class="fa fa-trash"></i></a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_url'=>$detail->getDetailUrl()])
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <h3 class="title mb-2">Thêm item</h3>
            
            <div class="card card-default menu-item-card">
                @include($__theme.'menu.templates.form-list')
            </div>
        </div>
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <!-- list content -->
            @if(count($list = $detail->items())>0)
            <h3 class="title mb-2">Danh sách item</h3>
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
                            <div class="item-col item-col-header item-col-title item-col-same-md">
                                <div>
                                    <span>Tiêu đề</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-same-sm item-col-stats">
                                <div class="no-overflow">
                                    <span>Loại</span>
                                </div>
                            </div>

                            <div class="item-col item-col-header item-col-same-sm item-col-stats">
                                <div class="no-overflow">
                                    <span>Ưu tiên</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header fixed item-col-actions-dropdown item-col-same-sm"> </div>
                        </div>
                    </li>
                    @foreach($list as $item)
                    <?php $item->applyMeta(); ?>
                    <li class="item" id="item-{{$item->id}}">
                        <div class="item-row">
                            <div class="item-col fixed item-col-check">
                                <label class="item-check">
                                    <input type="checkbox" name="items[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                    <span></span>
                                </label>
                            </div>
                            <div class="item-col fixed item-col-check">
                                <span>{{$item->id}}</span>
                            </div>
                            <div class="item-col fixed pull-left item-col-title item-col-same-md">
                                <div class="item-heading">Tiêu đề</div>
                                <div>
                                    <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->title}}"> {{$item->title?$item->title:($item->icon?'Icon: '.$item->icon:'')}} </h4>
                                </div>
                            </div>
                            <div class="item-col item-col-same-sm item-col-stats no-overflow">
                                <div class="item-heading">Loại</div>
                                <div class="no-overflow">
                                    {{$item->type}}
                                </div>
                            </div>
                            <div class="item-col item-col-same-sm item-col-stats">
                                <div class="item-heading">Ưu tiên</div>
                                <div>

                                    <div class="btn-group item-priority-select">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{$item->priority}}
                                        </button>
                                        {!! 
                                            (new Cube\Html\Menu([
                                                    'type'=>'list',
                                                    'data'=>$item->getPriorityMenuList()
                                                ],[
                                                    'id' => 'dropdown-item-'.$item->id,
                                                    'class' => 'dropdown-menu priority-select',
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
                                            <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}">
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    
                </div>
            </div>
            @else
                <div class="text-center alert alert-danger">
                    Chưa có item nào
                </div>
            @endif
        </div>
    </div>


</article>
@include($__current.'templates.modals')
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
    window.menuItemsInit = function() {
        Cube.menuItems.init({
            urls:{
                change_priority_url:  '{{route('admin.menu.item.change-priority')}}',
            }
        });
    };
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.menu.item.delete')}}'
            }
        });
    };
</script>
@endsection

@section('js')
<script src="{{asset('js/admin/menu.items.js')}}"></script>
@endsection
