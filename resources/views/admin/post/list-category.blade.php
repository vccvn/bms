@extends($__layouts.'main')

@section('title', 'Chủ đề')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Chủ đề bài viết
                        <a href="{{route('admin.post.category.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        
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

        <ul class="item-list striped list-body list-category">
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
                            <span>Tên chủ dề</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Chủ đề cha</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-roles item-col-stats">
                        <div class="no-overflow">
                            <span>Số bài viết</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Menu</span>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Trang chủ</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header fixed item-col-same item-col-stats"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="category-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="postcate[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
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
                        <a href="{{route('admin.post.category.update',['id'=>$item->id])}}">
                            <div class="item-img rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tên chủ đề</div>
                        <div>
                            <a href="{{route('admin.post.category.update',['id'=>$item->id])}}" class="">
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
                        <div class="item-heading">Số sản Bài viết</div>
                        <div class="no-overflow">
                            {{$item->posts()->count()}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats no-overflow">
                        <div class="item-heading">Hiển thị menu</div>
                        <div class="no-overflow">
                            {{$item->is_menu?"Có":"không"}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Hiển thị trang chủ</div>
                        <div class="no-overflow">
                            {{$item->show_home?"Có":"không"}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-same item-col-stats md">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{route('admin.post.category.update',['id'=>$item->id])}}" class="edit ">
                                        <i class="fa fa-pencil"></i> sửa
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-category" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i></a> xóa
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
        <div class="alert alert-danger text-center">
            Danh sách trống
        </div>
        @endif    
    </div>
    



</article>

@endsection

@section('jsinit')
<script>
    window.categoriesInit = function() {
        Cube.categories.init({
            urls:{
                delete_url: '{{route('admin.post.category.delete')}}'
            }
        });
    };
</script>
@endsection