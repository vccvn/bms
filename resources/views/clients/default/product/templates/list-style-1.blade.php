<?php 
use Illuminate\Support\Facades\Input;
$keyword = Input::get('s'); 
$perpage = Input::get('perpage'); 
$sortby = Input::get('sortby'); 

$perpages = [10,25,50];
$arrSort = [
    "price-up"=>'Giá tăng dần',
    'price-down' => 'Giá giảm dần',
    "likes"=>"Lượt thích",
    "lastest"=>'Mới nhất',
];
$min_price = Input::get('min_price');
$max_price = Input::get('max_price');

$count = $total;
?>

                    <!--News Section-->
                    <section class="products-section">
						
                        <div class="shop-upper-box">
                            <div class="clearfix">
                                <div class="pull-left items-label">Hiển thị {{($current_page-1)*12+1}}-{{$count<12?$count:12}} trên {{$count}} sản phẩm</div>
                                <div class="pull-right sort-by" name="sortby">
                                	<select class="sort-select">
                                        @foreach($arrSort as $type => $text)
                                            <option value="{{$type}}"{{$type==$sortby?' selected':''}}>{{$text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @include($__current.'templates.list')
                   		
                    </section>
                