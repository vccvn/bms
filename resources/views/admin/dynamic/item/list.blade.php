@extends($__layouts.'main')

@section('title', $post->title)

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> {{$post->title}}
                        <a href="{{route('admin.dynamic.item.add',['slug'=>$post->slug])}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_url'=>route('admin.dynamic.item.list',['slug'=>$post->slug])])
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        @include($__templates.'list-filter',['filter_list'=>['title'=>'Tên / Tiêu đề ','views'=>'Lượt xem','created_at' => 'Thời gian']])
        @if($list->count()>0)
        <ul class="item-list striped list-body list-page">
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
                            <span>Tên {{$post->title}}</span>
                        </div>
                    </div>
                    @if ($post->use_category)
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div>
                            <span>Danh mục</span>
                        </div>
                    </div>
                    
                    @endif
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Lượt xem</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same item-col-stats"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <?php
                $update_url = route('admin.dynamic.item.update',['slug'=>$post->slug, 'id'=>$item->id]);
            ?>
            <li class="item" id="page-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="posts[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="{{$update_url}}">
                            <div class="item-img rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tên {{$post->title}}</div>
                        <div>
                            <a href="{{$update_url}}" class="">
                                <h4 class="item-title" id="page-title-{{$item->id}}"> {{$item->title}} </h4>
                            </a>
                        </div>
                    </div>
                    @if ($post->use_category)
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            {{$item->getCategory()->name}}
                        </div>
                    </div>
                    
                    @endif
                    
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div class="no-overflow">
                            {{$item->getShortDesc(64)}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats no-overflow">
                        <div class="item-heading">Lượt xem</div>
                        <div class="no-overflow">
                            {{$item->views}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-same item-col-stats">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{$update_url}}" class="edit text-success">
                                        <i class="fa fa-pencil"></i>
                                        Sửa
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-page text-danger" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i>
                                        Xóa
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-page"><i class="fa fa-trash"></i></a>
                    
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
    window.pagesInit = function() {
        Cube.pages.init({
            urls:{
                delete_url: "{{route('admin.dynamic.item.delete',['slug'=>$post->slug])}}"
            }
        });
    };
</script>
@endsection


