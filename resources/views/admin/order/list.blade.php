@extends($__layouts.'main')

@section('title', 'Đơn hàng')

@section('content')

<?php
    $stt_color_types = [-1=>'danger', 0 => 'secondary', 300 => 'warning', 600 => 'primary'];
    $stt_labels = ['canceled' => 'bị hủy', 'newest' => 'mới', 'processing' => 'dang sử lý', 'completed' => 'đã hoàn thành'];
?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Đơn hàng 
                        {{
                            (isset($slug) && isset($stt_labels[$slug])) ? $stt_labels[$slug] : ''
                        }}

                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_url'=>route('admin.order.list')])
    </div>
    <!-- list content -->
    
    <div class="card items">
        @include($__templates.'advance-filter',[
            'filter_list'=>[
                'name'=>'Tên khách hàng',
                'email'=>'Email',
                'phone_number'=>'Số điện thoại',
                'created_at' => 'Thời gian',
                'payment_method' => 'Phương thức thanh toán'
            ]
        ])
        @if(count($list)>0)
        <ul class="item-list striped list-body list-order">
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
                    <div class="item-col item-col-header item-col-title item-col-same">
                        <div>
                            <span>Họ và Tên</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Số điện thoại</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Email</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>P.T. Thanh toán</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Thời gian</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Trạng thái</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Chi tiết</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="order-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="order[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-check">
                        <span>{{$item->id}}</span>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Họ tên</div>
                        <div>
                            <h4 class="item-title"> 
                                <a href="{{$item->getDetailUrl()}}">{{$item->name}}</a> 
                            </h4>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Số điện thoại</div>
                        <div class="no-overflow">
                            {{$item->phone_number}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Email</div>
                        <div class="no-overflow">
                            {{$item->email}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">P.T Thanh toán</div>
                        <div class="no-overflow">
                            {{$item->getPaymentText()}}
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Thời gian</div>
                        <div class="no-overflow">
                            {{$item->dateFormat('H:i - d/m/Y')}}
                        </div>
                    </div>
                    <div class="item-col item-col-roles item-col-stats item-col-same">
                        <div class="item-heading">Trạng thái</div>
                        <div>
                            <div class="btn-group order-status-select select-dropdown">
                                <button type="button" class="btn btn-secondary text-{{isset($stt_color_types[$item->status])?$stt_color_types[$item->status]:'secondary'}} btn-sm dropdown-toggle status-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$item->getStatusText()}}
                                </button>
                                <div class="dropdown-menu status-select select-dropdown-menu">
                                    @forelse($item->getStatusMenu() as $st => $t)
                                    <a data-id="{{$item->id}}" data-status="{{$st}}" id="order-item-{{$item->id}}-{{$st}}" href="#" title="chuyển sang {{$t}}" class="dropdown-item nav-link pt-1 pb-1 {{$st==$item->status?'active':''}}"> {{$t}} </a>
                                    @empty

                                    @endforelse
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="item-col item-col-stats no-overflow">
                        <div class="item-heading">Chi tiết</div>
                        <div class="no-overflow">
                            <a href="{{$item->getDetailUrl()}}" class="view-order-detail" data-id="{{$item->id}}">Xem</a>
                        </div>
                    </div>
                    <div class="item-col fixed item-col-actions-dropdown">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="#" class="remove btn-delete-order" data-id="{{$item->id}}">
                                        <i class="fa fa-trash-o"></i>
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-order"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        {{$list->links('vendor.pagination.custom')}}
                    </nav>
                </div>
            </div>
        </div>
        @else
            <div class="text-center alert alert-danger">
                không có đơn hàng nào
            </div>
        @endif
        
    </div>
    
</article>

@endsection

@section('jsinit')
<?php 
    $templates = [
        'row' => '
        <div class="row">
            <div class="col-sm-3 ">
                <strong>{$label}</strong>
            </div>
            <div class="col-sm-9">
                {$detail}
            </div>
        </div>
        ',
        'product_list' => '<ul class="product-list">{$items}</ul>',
        'product_item' => '<li class="product-item">
            <div class="row list-product">
                <div class="col-4">
                    <a href="{$link}" target="_blank">{$name}</a>
                </div>
                <div class="col-3">
                    {$price}VNĐ
                </div>
                <div class="col-1">
                    x{$qty}
                </div>
                <div class="col-4">
                    {$total_price}VNĐ
                </div>
            </div>
        </li>'
    ];
    $labels = [
        'name' => 'Họ và tên',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'address' => 'Địa chỉ',
        'products' => 'Danh sách Sản phẩm',
        'total_money' => 'Tổng hóa đơn',
        'notes' => 'Ghi chú',
        'status' => "Trạng thái"
    ];
?>
<script>
    window.ordersInit = function() {
        Cube.orders.init({
            urls:{
                delete_url: '{{route('admin.order.delete')}}',
                change_status_url:  '{{route('admin.order.change-status')}}',
                view_url: '{{route('admin.order.view')}}'
            },
            status_color_types:{!! json_encode($stt_color_types) !!},
            templates: {!! json_encode($templates) !!},
            labels: {!! json_encode($labels) !!}

        });
    };
</script>
@endsection
@section('js')
    <script src="{{asset('js/admin/orders.js')}}"></script>
    <script src="{{asset('plugins/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('plugins/datetimepicker/bootstrap.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('input.filter-date, #datepicker-from, #datepicker-to').datetimepicker({
                locale: 'vi',
                format: 'YYYY-MM-DD'
            });
        });
    </script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" media="all" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />
    <style>
        .filter-form .row>div{
            padding-top: 15px;
        }
        .filter-form .form-group{
            margin-bottom: 5px;
        }
        ul.product-list{
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .product-item{
            list-style: none;
        }
        .list-product{
            border-top: 1px solid silver;
        }
        .list-product:last-child{
            border-bottom: 1px solid silver;
        }

        .list-order .item-col-title a{
            text-decoration: none;
        }

    </style>
@endsection