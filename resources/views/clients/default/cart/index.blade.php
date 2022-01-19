
@extends($__layouts.'fullwidth-page-title')

@section('title','Giỏ hàng')

@section('content')

        <!--Cart Section-->
        <section class="cart-section">
            <div class="auto-container">
                @if($cart_data['qty'])
                <!--Cart Outer-->
                <div class="cart-outer">
                    <div class="table-outer">
                        <table class="cart-table">
                            <thead class="cart-header">
                                <tr>
                                    <th><span class="fa fa-trash-o"></span></th>
                                    <th class="prod-column">Sản phẩm</th>
                                    <th class="price">Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach($cart_data['products'] as $p)
                                <tr id="product-cart-item-{{$p['key']}}">
                                    <td class="remove"><a href="#" class="remove-btn btn-remove-cart-item" data-key="{{$p['key']}}"><span class="fa fa-remove"></span></a></td>
                                    <td class="prod-column">
                                        <div class="column-box">
                                            <figure class="prod-thumb"><a href="#"><img src="{{$p['image']}}" alt=""></a></figure>
                                            <h4 class="prod-title">{{$p['name']}}</h4>
                                        </div>
                                    </td>
                                    <td class="price">{{number_format($p['price'], 0, ',', '.')}}</td>
                                    <td class="qty"><input class="quantity-spinner item-quantity" type="text" value="{{$p['qty']}}" name="quantity" data-key="{{$p['key']}}"></td>
                                    <td class="sub-total" id="item-total-price-{{$p['key']}}">{{number_format($p['total_price'], 0, ',', '.')}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="cart-options clearfix">
                        {{-- <div class="pull-left">
                            <div class="apply-coupon clearfix">
                                <div class="form-group clearfix">
                                    <input type="text" name="coupon-code" value="">
                                </div>
                                <div class="form-group clearfix">
                                    <button type="button" class="theme-btn btn-style-one">Áp dụng mã Coupon</button>
                                </div>
                            </div>
                        </div> --}}
                        
                        <div class="pull-right">
                            <button type="button" class="theme-btn btn-style-one btn-go-to-checkout">Thanh toán</button>
                            <button type="button" class="theme-btn btn-style-three btn-update-cart">Cập nhật</button>
                        </div>
                        
                    </div>
                    
                    <div class="row clearfix">
                        
                        <div class="column pull-right col-md-4 col-sm-8 col-xs-12">
                            <h3>Cart Totals</h3>
                            <!--Totals Table-->
                            <ul class="totals-table">
                                <li class="clearfix title"><span class="col">Sub Total</span><span class="col cart-total-money">{{number_format($cart_data['total_money'], 0, ',', '.')}} VNĐ</span></li>
                                <li class="clearfix"><span class="col">Order</span><span class="col total cart-total-money-vat">{{number_format($__setting->order_VAT?($cart_data['total_money']*(1+($__setting->order_VAT/100))):$cart_data['total_money'], 0, ',', '.')}} VNĐ</span></li>
                            </ul>
                            
                        </div>
                        
                    </div>
                    
                    
                </div>
                @else
                <div class="alert alert-warning text-center">
                    Hiện không có sản phẩm nào trong giỏ hàng
                </div>
                @endif
            </div>
        </section>
    

@endsection

@if(!$cart_data['qty'])
    @section('js')
        <script>
            $(document).ready(function(){
                Cube.storage.set('cart_total',0);
                Cube.cart.updateCartTotal(0);
            });
        </script>
    @endsection
@endif

