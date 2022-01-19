

                        <aside class="sidebar blog-sidebar">

                            <!-- Search Form -->
                            <div class="sidebar-widget search-box">
                                <div class="sidebar-title"><h2>Tìm kiếm</h2></div>
                                <form method="get" action="{{route('client.search')}}">
                                    <input type="hidden" name="cate" value="product">
                                    <div class="form-group">
                                        <input type="search" name="s" value="" placeholder="Nhập từ khóa">
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>
                            

                            @if(count($categories = get_pupular_category_list('product')))

                            <!-- Categories -->
                            <div class="sidebar-widget recent-articles wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Danh mục</h2></div>
                                <ul class="list">
                                    @foreach($categories as $cate)
                                    <li><a href="{{$cate->getViewUrl()}}" class="clearfix">{{$cate->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            @endif
                            
                            <!-- Price Filter -->
                            <div class="sidebar-widget rangeslider-widget">
                                <div class="sidebar-title"><h2>Lọc theo mức giá</h2></div>
                                    
                                <div class="range-slider-price" id="range-slider-price"></div>
                                
                                <br>
                                <div class="form-group">
                                    <input type="text" name="min_price" class="val-box" id="min-value-rangeslider">
                                    <input type="text" name="max_price" class="val-box" id="max-value-rangeslider">
                                    <button type="button">Lọc</button>
                                </div>
                            </div>

                            @if(count($posts = get_product_list(['@order_by'=>['created_at'=>'DESC'],'@limit'=>6])))

                            <!-- best sellerss -->
                            <div class="sidebar-widget best-sellers wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>sản phẩm nổi bật</h2></div>
                                @foreach($posts as $p)


                                <div class="item">
                                    <div class="post-thumb"><a href="{{$p->getViewUrl()}}"><img src="{{$p->getFeatureImage('90x90')}}" alt="{{$p->name}}"></a></div>
                                    <h4><a href="{{$p->getViewUrl()}}">{{$p->name}}</a></h4>
                                    {{-- <div class="rating"><span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span></div> --}}
                                    <div class="item-price">{{number_format($p->sale_price, 0, ',','.')}} Đ</div>
                                </div>
                            
                                @endforeach
                                
                            </div>
                            @endif

                            @if($tags = get_popular_tags(['@limit'=>6]))
                            <!-- Tags -->
                            <div class="sidebar-widget popular-tags wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Thẻ</h2></div>
                                @foreach($tags as $tag)

                                <a href="{{route('client.search',['s'=>$tag->lower])}}">{{$tag->keywords}}</a>

                                @endforeach
                            </div>
                            
                            @endif
                        </aside>


                    

                        