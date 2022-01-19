
@extends($__layouts.'fullwidth-page-title')

@section('title','Thanh toán')

@section('content')
        
       	<!--Checkout Page-->
        <div class="checkout-page">
            <div class="auto-container">
                @if($cart_data['qty'])
                <?php
                $login = false;
                if($user = Auth::user()){
                    $user->checkMeta();
                    $login = true;
                    $name = $user->name;
                    $email = $user->email;
                    $phone_number = $user->phone_number;
                    $address = $user->address;
                    
                }else{
                    $name = null;
                    $email = null;
                    $phone_number = null;
                    $address = null;
                }

                ?>

                <!--Billing Details-->
                <div class="billing-details">
                    <div class="shop-form">
                        <form method="post" action="{{route('client.cart.place-order')}}" id="order-checkout-form">
                            {{csrf_field()}}
                            <div class="row clearfix">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    
                                    <div class="default-title"><h2>Thông tin giao hàng</h2></div>
                            
                                    <div class="row clearfix">
                                        
                                        
                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Hõ và tên <sup>*</sup></div>
                                            <input type="text" name="name" value="{{old('name', $name)}}" placeholder="Họ và tên" class="order-input">
                                            @if($errors->has('name'))
                                                <p class="text-danger has-error">{{$errors->first('name')}}</p>
                                            @endif
                                        </div>
                                        <!--Form Group-->
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Email <sup>*</sup></div>
                                            <input type="email" name="email" value="{{old('email', $email)}}" placeholder="Địa chỉ email" class="order-input">
                                            @if($errors->has('email'))
                                                <p class="text-danger has-error">{{$errors->first('email')}}</p>
                                            @endif
                                        </div>
                                        
                                        <!--Form Group-->
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Số điện thoại <sup>*</sup></div>
                                            <input type="text" name="phone_number" value="{{old('phone_number', $phone_number)}}" placeholder="Số điện thoại" class="order-input">
                                            @if($errors->has('phone_number'))
                                                <p class="text-danger has-error">{{$errors->first('phone_number')}}</p>
                                            @endif
                                        </div>
                                        
                                        <!--Form Group-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Địa chỉ </div>
                                            <input type="text" name="address" value="{{old('address', $address)}}" placeholder="Địa chỉ giao hàng" class="order-input">
                                            @if($errors->has('address'))
                                                <p class="text-danger has-error">{{$errors->first('address')}}</p>
                                            @endif
                                        </div>
                                        
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Ghi chú </div>
                                            <textarea name="notes" placeholder="Ghi chú đơn hàng.....">{{old('notes')}}</textarea>
                                            @if($errors->has('notes'))
                                                <p class="text-danger has-error">{{$errors->first('notes')}}</p>
                                            @endif
                                        </div>
                                        @if(!$login)
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="check-box"><input type="checkbox" name="create_account" id="account-option" {{old('create_account')?'checked':''}}> &ensp; <label for="account-option">Tạo tài khoản</label></div>
                                        </div>
                                        @endif


                                        <!--Place Order-->
                                        <div class="place-order ">
                                            <div class="default-title form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><h2>Phương thức thanh toán</h2></div>
                                            
                                            
                                            <!--Payment Options-->
                                            <div class="payment-options form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <ul>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment" id="payment-1" value="shipcode" checked>
                                                            <label for="payment-1">
                                                                <strong>Thanh toán khi nhận hàng</strong>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment" id="payment-3" value="paypal" disabled>
                                                            <label for="payment-3"><strong>Paypal</strong></label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" name="payment-group" id="payment-2" value="atm" disabled>
                                                            <label for="payment-2"><strong>ATM</strong></label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                        <button type="submit" class="theme-btn btn-style-one">Đặt hàng</button>
                                    </div>
                                </div>
                                
                                <div class="column pull-right col-md-4 col-sm-12 col-xs-12">
                                    <div class="default-title"><h2>Giỏ hàng</h2></div>
                                    <ul class="totals-table">
                                        <li class="clearfix title"><span class="col">Số sản phẫm</span><span class="col ">{{number_format($cart_data['total_qty'], 0, ',', '.')}}</span></li>
                                        <li class="clearfix title"><span class="col">Thành tiền</span><span class="col cart-total-money">{{number_format($cart_data['total_money'], 0, ',', '.')}} VNĐ</span></li>
                                        <li class="clearfix"><span class="col">Tỏng tiền sau VAT</span><span class="col total cart-total-money-vat">{{number_format($__setting->order_VAT?($cart_data['total_money']*(1+($__setting->order_VAT/100))):$cart_data['total_money'], 0, ',', '.')}} VNĐ</span></li>
                                        <li class="clearfix"><a href="{{route('client.cart')}}" class="theme-btn btn-style-three">Xem Giỏ hàng</a></li>
                                    </ul>
                                    <!--Totals Table-->
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!--End Billing Details-->
                @else
                <div class="alert alert-warning text-center">
                    Hiện không có sản phẩm nào trong giỏ hàng
                </div>
                @endif
            </div>
        </div>
    
    

@endsection

@if(!$cart_data['qty'])
    @section('js')
        <script>
            Cube.storage.set('cart_total',0);
            Cube.cart.updateCartTotal(0);
        </script>
    @endsection
@endif

