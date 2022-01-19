
@if($partner_slider && $partner_slider->items)
<?php
    $items = $partner_slider->items;
?>

        <section class="sponsors-style-one">
            <div class="auto-container">
                <div class="sec-title center">
                    <h2>Khách hàng & <span class="theme_color">Đối tác</span> </h2>
                    <span class="separator"></span>
                </div>
                <!--Sponsors Slider-->
                <ul class="sponsors-carousel-one owl-theme owl-carousel">
                    @foreach($items as $item)
                    
                    <li>
                        <div class="image-box tool_tip" title="media partner">
                            <a href="{{$item->link}}"><img src="{{$item->getImage()}}" alt="{{$item->title}}"></a>
                        </div>
                    </li>

                    @endforeach
                    
                    @foreach($items as $item)
                    
                    <li>
                        <div class="image-box tool_tip" title="media partner">
                            <a href="{{$item->link}}"><img src="{{$item->getImage()}}" alt="{{$item->title}}"></a>
                        </div>
                    </li>

                    @endforeach
                    
                </ul>
            </div>
        </section>

@endif