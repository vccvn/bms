@extends($__layouts.'main')

@section('title', 'Danh mục')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Danh mục {{$dynamic->title}}
                        <a href="{{route('admin.dynamic.category.add',['dynamic_slug' => $dynamic->slug])}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        {{-- @include($__templates.'list-search',['search_url'=>route('admin.dynamic.category.list',['dynamic_slug' => $dynamic->slug])]) --}}
    </div>
    <!-- list content -->
        
    <div class="card items">
        @include($__templates.'list-filter',[
            'filter_list'=>[
                'name'=>'Tên danh mục',
                'parent_id' => 'Danh mục cha',
                'created_at' => 'Thời gian'
            ]
        ])
        @if($list->count()>0)
    
        <ul class="item-list striped list-body list-product-category">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-check">
                        <div>ID</div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-img md">
                        <div>
                            <span>Ảnh</span>
                        </div>
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
                            <span>Số {{$dynamic->title}}</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Menu</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header fixed item-col-same item-col-stats text-center"> <div class="text-center">Actions</div> </div>
                </div>
            </li>
            @foreach($list as $item)
            <?php
                $update_url = $item->getUpdateUrl();
            ?>
            <li class="item" id="category-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="categories[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-check">
                        <div class="item-heading">ID</div>
                        <div>
                            {{$item->id}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="{{$update_url}}">
                            <div class="item-img rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tên danh mục</div>
                        <div>
                            <a href="{{$update_url}}" class="">
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
                        <div class="item-heading">Số {{$dynamic->title}}</div>
                        <div class="no-overflow">
                            {{$item->dynamics()->count()}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats no-overflow">
                        <div class="item-heading">Hiển thị menu</div>
                        <div class="no-overflow">
                            {{$item->is_menu?"Có":"không"}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-same item-col-stats md">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{$update_url}}" class="edit text-success">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-product-category btn text-danger" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i> Xóa
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-product-category"><i class="fa fa-trash"></i></a>
                    
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
    

</article>

@endsection

@section('jsinit')
<script>
    window.product_categoriesInit = function() {
        Cube.product_categories.init({
            urls:{
                delete_url: '{{route('admin.dynamic.category.delete',['dynamic_slug' => $dynamic->slug])}}'
            }
        });
    };
</script>
@endsection