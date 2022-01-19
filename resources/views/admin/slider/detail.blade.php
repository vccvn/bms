@extends($__layouts.'main')

@section('title', $title=$slider->name)

@section('content')


<article class="content items-list-page" id="slider-{{$slider->id}}">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Slider: <span id="slider-name-{{$slider->id}}">{{$title}}</span>
                        <a href="{{$slider->getAddItemUrl()}}" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-plus"></i> Thêm Slide Item </a>
                        
                        <a href="{{$slider->getUpdateUrl()}}" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-pencil-square-o"></i> </a>
                        
                        <a href="#" class="btn btn-danger btn-sm rounded-s btn-delete-slider" data-id="{{$slider->id}}"> <i class="fa fa-trash-o"></i> </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_url'=>$slider->getDetailUrl()])
    </div>
    <!-- list content -->
    @if(count($list)>0)
    <div class="card items">
        
        <ul class="item-list striped list-body list-slider">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header fixed item-col-img md">
                        <div>
                            <span>Ảnh</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Tiêu đề</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Link</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-roles item-col-stats">
                        <div class="no-overflow">
                            <span>Ưu tiên</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same-md ">
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
                    <div class="item-col fixed item-col-img md">
                        <a href="#">
                            <div class="item-img rounded" style="background-image: url({{$item->getImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tiêu đề</div>
                        <div>
                            <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->title}}"> {{$item->title}} </h4>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Link</div>
                        <div class="no-overflow">
                            <a href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div class="no-overflow ">
                            {{$item->getShortDesc(120)}}
                        </div>
                    </div>
                    <div class="item-col item-col-roles item-col-stats">
                        <div class="item-heading">Ưu tiên</div>
                        <div>

                            <div class="btn-group slider-item-priority-select">
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
                    <div class="item-col fixed item-col-same-md item-col-stats">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{$item->getUpdateUrl()}}" class="edit btn btn-sm btn-primary">
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
            <a href="#" class="btn btn-sm btn-danger btn-delete-all-slider-item"><i class="fa fa-trash"></i></a>
            
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
    
</article>

@endsection


@section('jsinit')
<script>
    window.slidersInit = function() {
        Cube.sliders.init({
            urls:{
                delete_url: '{{route('admin.slider.delete')}}',
                change_item_priority_url:  '{{route('admin.slider.item.change-priority')}}'
            }
        });
    };
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.slider.item.delete')}}'
            }
        });
    };
</script>
@endsection