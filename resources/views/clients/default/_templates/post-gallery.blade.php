@if(isset($gallery) && count($gallery))
<?php
    $data = [];
    $data['show'] = (isset($show) && $show) ? $show : 3;
    $data['dots'] = (isset($dots) && $dots) ? $dots : null;
    $data['nav'] = (isset($nav) && $nav) ? $nav : null;
    $data['loop'] = (isset($loop) && $loop) ? $loop : null;
    $data['step'] = (isset($step) && $step) ? $step : null;
    $data['speed'] = (isset($speed) && $speed) ? $speed : null;
    $data['margin'] = (isset($margin) && $margin) ? $margin : null;
    $data['delay'] = (isset($delay) && $delay) ? $delay : null;
    $data['autoplay'] = (isset($autoplay) && $autoplay) ? $autoplay : null;
?>
<div class="post-gallery gallery-slider">
    <div class="custom-item-carousel owl-theme owl-carousel owl-loaded" <?php
            foreach($data as $k => $v){
                if($v === true) $v = 'true';
                if($v) echo " data-$k=\"$v\"";
            }
        ?>>
        @foreach($gallery as $ga)
            <div class="post-gallery-item gallery-item slider-item">
                    <a class="lightbox-image option-btn" title="test" data-fancybox-group="example-gallery" href="{{$ga->getUrl()}}">
                    <img src="{{$ga->getUrl()}}" alt="">
                </a>
            </div>
        @endforeach
    </div>

</div>

@endif