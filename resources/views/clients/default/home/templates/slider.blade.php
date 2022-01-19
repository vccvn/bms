
@if($home_slider && $home_slider->items)
    <?php
        $items = $home_slider->items;
    ?>

        <section class="main-slider" data-start-height="700" data-slide-overlay="yes">

            <div class="tp-banner-container">
                <div class="tp-banner">
                    <ul>
                        @foreach($items as $item)

                        <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="{{$item->getImage()}}" data-saveperformance="off" data-title="{{$item->title}}">
                            <img src="{{$item->getImage()}}" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

                            <div class="tp-caption sfl sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="-100" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <h2 class="light">{{$item->title}}</h2>
                            </div>


                            <div class="tp-caption sfr sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="20" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <div class="text light">{!!nl2br($item->description)!!}</div>
                            </div>

                            <div class="tp-caption sfl sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="110" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <div class="btn-box">
                                    <a href="{{$item->link}}" class="theme-btn btn-style-one">Chi tiết</a>
                                    {{-- <a href="#" class="theme-btn btn-style-two mar-left-20">Liên hệ</a> --}}
                                </div>
                            </div>

                        </li>

                        @endforeach

                    </ul>

                    <div class="tp-bannertimer"></div>
                </div>
            </div>
        </section>

@endif