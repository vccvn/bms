<div class="main-slider">
    <div class="bms-carousel owl-carousel owl-theme main-slider-container" data-margin="0" data-show="1" data-autoplay="true" data-hover-pause="true" data-speed="1000" data-timeout="5000" data-loop="true" data-nav="true">
        @if($home_slider && $home_slider->items)
            <?php
                $items = $home_slider->items;
            ?>
        @foreach ($items as $item)
            
            <div class="item" style="background-image: url({{$item->getImage()}})">
                <div class="item-content">
                    <div class="container">
                        <div class="item-content-detail">
                            <h3>{{$item->title}}</h3>
                            <p>{!! nl2br($item->description) !!}</p>
                            @if ($item->link)
                            <a href="{{$item->link}}" class="btn btn-skew">Xem thêm</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
        @else
        <div class="item" style="background-image: url({{theme_url('assets/images/slide1.jpg')}})">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 1</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image: url({{theme_url('assets/images/slide2.jpg')}})">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 2</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image: url({{theme_url('assets/images/slide1.jpg')}})">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 3</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>