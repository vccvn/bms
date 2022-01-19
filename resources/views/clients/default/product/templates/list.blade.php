

                        @foreach($list as $item)
                        @if($loop->index%3==0)
                        <div class="row clearfix">
                        @endif
                            
                            <div class="default-shop-item col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <!--inner-box-->
                                <div class="inner-box">
                                    <!--image-box-->
                                    <figure class="image-box">
                                        <a href="{{$item->getViewUrl()}}"><img src="{{$item->getFeatureImage()}}" alt="{{$item->name}}" /></a>
                                        <div class="overlay-box">
                                            <a href="#" class="cart-btn btn-add-to-cart" data-id="{{$item->id}}">Thêm vào giỏ hàng</a>
                                        </div>
                                        @if($item->sale_price < $item->list_price)
                                        <div class="item-sale-tag">Sale</div>
                                        @endif
                                    </figure>
                                    
                                    <!--lower-content-->
                                    <div class="lower-content">
                                        <h3><a href="{{$item->getViewUrl()}}">{{$item->name}}</a></h3>
                                        
                                        {{-- <div class="rating">
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star-o"></span>
                                        </div> --}}
                                        
                                        <div class="price">{{number_format($item->sale_price, 0, ',','.')}} Đ</div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                        @if($loop->index%3==2 || $loop->last)
                        </div>
                        @endif
                        @endforeach
                        