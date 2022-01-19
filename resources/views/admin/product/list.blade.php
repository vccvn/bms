@extends($__layouts.'main')

@section('title', 'Sản phẩm')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Sản phẩm
                        <a href="{{route('admin.product.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
        
    <div class="card items">
        @include($__templates.'list-filter',['filter_list'=>['name'=>'Tên sản phẩm','created_at' => 'Thời gian']])
        @if($list->count()>0)
    
        <ul class="item-list striped list-body list-product">
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
                    <div class="item-col item-col-header item-col-title">
                        <div>
                            <span>Tên sản phẩm</span>
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
                    {{-- <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Giá gốc</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Giá bán</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>số lượng</span>
                        </div>
                    </div> --}}
                    <div class="item-col item-col-header fixed item-col-same-md item-col-stats"> 
                        <div class="text-center">Actions</div>
                    </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="product-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="products[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="{{$item->getUpdateUrl()}}">
                            <div class="item-img rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-title">
                        <div class="item-heading">Tên sản phẩm</div>
                        <div>
                            <a href="{{$item->getUpdateUrl()}}" class="">
                                <h4 class="item-title" id="product-name-{{$item->id}}"> {{$item->name}} </h4>
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            {{$item->getCategory()->name}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Mô tả</div>
                        <div class="no-overflow">
                            {{$item->getShortDesc(64)}}
                        </div>
                    </div>
                    {{-- <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Giá gốc</div>
                        <div class="no-overflow">
                            {{$item->list_price}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Giá bán</div>
                        <div class="no-overflow">
                            {{$item->sale_price}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same no-overflow">
                        <div class="item-heading">Số lượng</div>
                        <div class="no-overflow">
                            {{$item->total}}
                        </div>
                    </div> --}}
                    <div class="item-col fixed item-col-same-md item-col-stats">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="{{$item->getUpdateUrl()}}" class="edit btn btn-sm btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-product btn btn-sm btn-danger-outline" data-id="{{$item->id}}">
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-product"><i class="fa fa-trash"></i></a>
                    
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
    window.productsInit = function() {
        Cube.products.init({
            urls:{
                delete_url: '{{route('admin.product.delete')}}'
            }
        });
    };
</script>
@endsection