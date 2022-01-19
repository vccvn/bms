<?php 
$category = $product->category;
$tags = $product->getTags();
$article = $product;
?>
@extends($__layouts.'sidebar')
@section('sidebar','shop')

@include($__utils.'register-meta')

@section('content')



    <!--Shop Single-->
    <div class="shop-single">
        <div class="auto-container">

            <!--Product Details Section-->
            <section class="product-details">
                <!--Basic Details-->
                <div class="basic-details">
                    <div class="row clearfix">
                        <div class="image-column col-md-6 col-sm-6 col-xs-12">
                            <figure class="image-box"><a href="{{$product->getViewUrl()}}" class="lightbox-image"><img src="{{$product->getFeatureImage()}}" alt="{{$product->name}}"></a></figure>
                        </div>
                        <div class="info-column col-md-6 col-sm-6 col-xs-12">
                            <div class="details-header">
                                <h4>{{$product->name}}</h4>
                                <div class="item-price">{{number_format($product->sale_price,0,',','.')}} Đ</div>
                            </div>
                            <div class="text">{{nl2br($product->description)}}</div>
                            <div class="stock"><a href="{{$category->getViewUrl()}}">{{$category->name}}</a></div>
                            <div class="other-options clearfix">
                                <div class="item-quantity"><input class="quantity-spinner" type="text" value="2" name="quantity" id="product-quantity"></div>
                                <button type="button" class="theme-btn btn-style-one add-to-cart btn-add-to-cart-with-qty" data-id="{{$product->id}}">Thêm vào giỏ hàng</button>
                            </div>

                            <!--Item Meta-->
                            <ul class="item-meta">
                                <li>Thẻ: 
                                    @foreach($tags as $tag)
                                        <a href="{{route('client.search',['cate'=>'product','s'=>$tag->keywords])}}">{{$tag->keywords}} </a>{{$loop->last?'':', '}}
                                    @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
                <!--Basic Details-->

                @include($__current.'templates.info-tabs')
                {{-- nut like --}}
                @include($__utils.'social-buttons', [
                    'link'=>$article->getViewUrl(),
                    'title' => $article->name
                ])

                <!--Comments Area-->
                @include($__templates.'comments',[
                    'comments'=>$article->publishComments,
                    'object' => 'product',
                    'object_id' => $article->id,
                    'link' => $article->getViewUrl()
                ])



                @include($__current.'templates.related')

                
            </section>

        </div>
    </div>

@endsection
