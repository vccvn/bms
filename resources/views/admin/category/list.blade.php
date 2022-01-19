@extends($__layouts.'main')

@section('title', 'Danh mục')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Danh mục
                        <a href="{{route('admin.category.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.category.list'])
    </div>
    <!-- list content -->
    @if($list->count()>0)
        
    <div class="card items">
        <ul class="item-list striped list-body list-category">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Tên danh mục</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Danh mục cha</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-roles item-col-stats">
                        <div class="no-overflow">
                            <span>Số sản phẩm</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Menu</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="category-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="categories[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tên danh mục</div>
                        <div>
                            <a href="#" class="">
                                <h4 class="item-title"> {{$item->name}} </h4>
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Danh mục cha</div>
                        <div class="no-overflow">
                            @if($parent = $item->getParent())
                                {{$parent->name}}
                            @else
                                Không
                            @endif
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div>
                            {{$item->getShortDesc(40)}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Số sản phẩm</div>
                        <div class="no-overflow">
                            {{$item->products()->count()}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats no-overflow">
                        <div class="item-heading">Hiển thị menu</div>
                        <div class="no-overflow">
                            {{$item->is_menu?"Có":"không"}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-actions-dropdown">
                        <div class="item-actions-dropdown">
                            <a class="item-actions-toggle-btn">
                                <span class="inactive">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="active">
                                    <i class="fa fa-chevron-circle-right"></i>
                                </span>
                            </a>
                            <div class="item-actions-block">
                                <ul class="item-actions-list">
                                    <li>
                                        <a href="{{$item->getUpdateUrl()}}" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="remove btn-delete-category" data-id="{{$item->id}}">
                                            <i class="fa fa-trash-o"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        
    </div>
    <div class="card card-block ">
        <div class="row pt-4">
            <div class="col-12 col-md-6">
                <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                <a href="#" class="btn btn-sm btn-danger btn-delete-all-category"><i class="fa fa-trash"></i></a>
                
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



</article>

@endsection

@section('jsinit')
<script>
    window.categoriesInit = function() {
        Cube.categories.init({
            urls:{
                delete_url: '{{route('admin.category.delete')}}'
            }
        });
    };
</script>
@endsection