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
            <div class="card items menu-items">
                
                <div class="cf nestable-lists">

                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach($list as $item)
                            <?php $item->applyMeta(); ?>

                            <li class="dd-item" data-id="{{$item->id}}" id="item-{{$item->id}}">
                                <div class="item-actions">
                                    <a href="{{$item->getUpdateUrl()}}" class="edit btn-edit-item" data-id="{{$item->id}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                        <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                                <div class="dd-handle" id="item-name-{{$item->id}}" data-name="{{$item->title}}">{{$item->title?$item->title:($item->icon?'Icon: '.$item->icon:'')}}</div>
                                @if($item->children)
                                <ol class="dd-list">
                                    @foreach($item->children as $child)
                                    <?php $child->applyMeta(); ?>
                                        
                                    <li class="dd-item" data-id="{{$child->id}}" id="item-{{$child->id}}">
                                        <div class="item-actions">
                                    
                                            <a href="{{$child->getUpdateUrl()}}" class="edit btn-edit-item" data-id="{{$child->id}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="remove btn-delete-item" data-id="{{$child->id}}">
                                                <i class="fa fa-trash-o"></i></a>
                                    
                                        </div>
                                        <div class="dd-handle" id="item-name-{{$child->id}}" data-name="{{$child->title}}">{{$child->title?$child->title:($child->icon?'Icon: '.$item->icon:'')}}</div>
                                        
                                    </li>
                                    @endforeach
                                </ol>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </div>
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


@section('css')
    <link rel="stylesheet" href="{{asset('css/nestable2.css')}}" />
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
                sort_url:  '{{route('admin.menu.item.sort')}}',
                form_url:  '{{route('admin.menu.item.form')}}',
                save_url:  '{{route('admin.menu.item.ajax-save')}}',
            },
            menu_id: {{$detail->id}}
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
<script src="{{asset('js/admin/jquery.nestable.js')}}"></script>
<script src="{{asset('js/admin/menu.items.js')}}"></script>

@if($errors->first())
    <script>
        $(function(){
            modal_alert('{{$errors->first()}}');
        });
    </script>
@endif
        
@endsection
