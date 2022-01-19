
@extends($__layouts.'main')

@section('title', 'Bảng giá vé')

@section('content')

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Bảng giá vé
                        <a href="{{route('admin.ticket.price.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        @include('admin._templates.search-filter',[
            'search_filter'=>[
                'route' => 'Tên tuyến',
                'company' => 'Nhà xe',
                'price' => 'Giá vé'
            ]
        ])
        @if($list->count()>0)
        <div class="cart cart-block pl-3 pr-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <label class="d-block">
                                    <input type="checkbox" name="check_all" class="check-all checkbox">
                                    <span></span>
                                </label>
                            </th>    
                            <th>
                                Mã số
                            </th>    
                            <th>
                                Nhà xe
                            </th>    
                            <th>
                                Tuyến
                            </th>    
                            <th>
                                Giá vé (VNĐ)
                            </th>
                            <th>
                                #
                            </th>    
                            
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        @foreach ($list as $item)
                            <tr id="item-{{$item->id}}">
                                <th>
                                    <label class="d-block">
                                        <input type="checkbox" name="roles[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                        <span></span>
                                    </label>
                                </th>
                                <td>
                                    {{$item->id}}
                                </td>
                                <td>
                                    {{$item->company}}
                                </td>
                                <td>
                                    {{$item->from_station}} 
                                    <i class="fa fa-long-arrow-right"></i>
                                    {{$item->to_station}}
                                </td>
                                <td>
                                    {{number_format($item->price, 0, ',', '.')}}
                                </td>
                                <td>
                                    <a href="{{$item->getUpdateUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm btn-delete-item" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
    
                </table>
            </div>
        </div>
        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-4">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-8">
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
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.ticket.price.delete')}}'
            }
        });
    };
</script>
@endsection

@section('css')
    <style>
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endsection