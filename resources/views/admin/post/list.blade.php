@extends($__layouts.'main')

@section('title', "Tin bài")

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Tin bài
                        <a href="{{route('admin.post.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        @include($__templates.'list-filter',['filter_list'=>['title'=>'Tiêu đề','category'=>'Danh mục','views'=>'Lượt xem','created_at' => 'Thời gian']])
        @if($list->count()>0)
        <ul class="item-list striped list-body list-post">
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
                            <span>Tiêu đề bài viết</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Danh mục</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Mô tả</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Lượt xem</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same item-col-stats"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="post-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="posts[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="{{$item->getUpdateUrl()}}">
                            <div class="item-img rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tiêu đề</div>
                        <div>
                            <a href="{{$item->getUpdateUrl()}}" class="">
                                <h4 class="item-title" id="post-title-{{$item->id}}"> {{$item->title}} </h4>
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            {{$item->category->name}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div class="no-overflow">
                            {{$item->getShortDesc(64)}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Lượt xem</div>
                        <div class="no-overflow">
                            {{$item->views}}
                        </div>
                    </div>
                    <div class="item-col fixed item-col-stats item-col-same pull-right">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{$item->getUpdateUrl()}}" class="edit btn btn-sm btn-success">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-post btn btn-danger btn-sm" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i></a>
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-post"><i class="fa fa-trash"></i></a>
                    
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
    window.postsInit = function() {
        Cube.posts.init({
            urls:{
                delete_url: '{{route('admin.post.delete')}}'
            }
        });
    };
</script>
@endsection