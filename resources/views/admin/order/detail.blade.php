@extends($__layouts.'main')

@section('title', 'Chi tiết đơn hàng')

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
                    <h3 class="title"> Chi tiết đơn hàng </h3>
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.order.list'])
    </div>
    <!-- list content -->
        
    <div class="card items" id="order-item-{{$order->id}}">
        <div class="card card-block">

            <div class="row order-info pt-1 pb-3">
                <div class="col-6 status">
                    Trạng thái:
                        <div class="btn-group order-status-select select-dropdown">
                            <button type="button" class="btn btn-secondary text-{{isset($stt_color_types[$order->status])?$stt_color_types[$order->status]:'secondary'}} btn-sm dropdown-toggle status-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$order->getStatusText()}}
                            </button>
                            <div class="dropdown-menu status-select select-dropdown-menu">
                                @forelse($order->getStatusMenu() as $st => $t)
                                <a data-id="{{$order->id}}" data-status="{{$st}}" id="order-item-{{$order->id}}-{{$st}}" href="#" title="chuyển sang {{$t}}" class="dropdown-item nav-link pt-1 pb-1 {{$st==$order->status?'active':''}}"> {{$t}} </a>
                                @empty

                                @endforelse
                            </div>    
                        </div>
                </div>
                <div class="col-6 action text-right">
                    <a href="#" class="remove btn-delete-order" data-id="{{$order->id}}">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-5">
                    <h4>Danh sách sản phẩm</h4>
                    <div class="products">
                        <?php 
                            $qty = 0; 
                            $__setting = getSetting();
                        ?>
                        @foreach($order->products as $p)
                        <?php 
                        $prod = $p->detail; 
                        $qty+= $p->product_qty;
                        ?>
                        
                        <div class="row item">
                            <div class="col-6 col-md-4 image">
                                <a href="{{$prod->getViewUrl()}}">
                                    <img src="{{$prod->getImage()}}" alt="{{$prod->name}}">
                                </a>
                            </div>
                            <div class="col-6 col-md-8">
                                <h5>
                                    <a href="{{$prod->getViewUrl()}}">
                                        {{$prod->name}}
                                    </a>
                                </h5>
                                <p class="price">Đơn giá: <span>{{number_format($p->date_price, 0, ',', '.')}}</span></p>
                                <p class="qty">Số lượng: <span>{{$p->product_qty}}</span></p>
                                <p class="money">Thành tiền: <span>{{number_format($p->total(), 0, ',', '.')}}</span></p>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    <div class="order-total">

                        <div class="row">
                            <div class="col-6 col-md-4">
                                <strong>Tổng số sản phẩm</strong>
                            </div>
                            <div class="col-6 col-md-8">
                                {{number_format($qty, 0, ',', '.')}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <strong>Thành tiền</strong>
                            </div>
                            <div class="col-6 col-md-8">
                                {{number_format($order->total_money, 0, ',', '.')}} VNĐ
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <strong>Tổng tiền sau VAT</strong>
                            </div>
                            <div class="col-6 col-md-8">
                                {{number_format(
                                    $__setting->VAT?(
                                        $order->total_money*(1+($__setting->VAT/100))
                                    ):$order->total_money, 0, ',', '.'
                                )}} VNĐ
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-6 mb-5">
                    <h4>Thông tin giao hàng</h4>
                    <div class="row mt-3">
                        <div class="col-6 col-md-4">
                            <strong>Họ và tên</strong>
                        </div>
                        <div class="col-6 col-md-8">
                            {{$order->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <strong>Email</strong>
                        </div>
                        <div class="col-6 col-md-8">
                            {{$order->email}}
                        </div>
                    </div>
                    @if($order->phone_number)
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <strong>Số điện thoại</strong>
                        </div>
                        <div class="col-6 col-md-8">
                            {{$order->phone_number}}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <strong>Địa chỉ</strong>
                        </div>
                        <div class="col-6 col-md-8">
                            {!! nl2br($order->address) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <strong>Ghi chú</strong>
                        </div>
                        <div class="col-6 col-md-8">
                            {!! nl2br($order->notes) !!}
                        </div>
                    </div>
                
                    
                </div>
            </div>
        </div>
    </div>
    
</article>

@endsection


@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.order.delete')}}'
            }
        });
    };
    window.ordersInit = function() {
        Cube.orders.init({
            urls:{
                delete_url: '{{route('admin.order.delete')}}',
                change_status_url:  '{{route('admin.order.change-status')}}',
                view_url: '{{route('admin.order.view')}}'
            },
            status_color_types:{!! json_encode($stt_color_types) !!}
        });
    };
</script>
@endsection
@section('js')
<script src="{{asset('js/admin/orders.js')}}"></script>

@endsection
@section('css')
    <style>
        .contact-reply{
            border-bottom: 1px silver solid;
        }
        .products .item{
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px dotted silver;
        }
        .products .item a{
            color: #000;
            text-decoration: none;
        }
        .products .image{
            text-align: center;
        }
        .products img{
            max-width: 100%;
            max-height: 120px;
        }
    </style>
@endsection