
                @foreach($list as $item)
                @if($loop->index%2==0)
                <div class="row">
                @endif    
                    <!--Services Block-->
                    <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        <div class="inner-box" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
                            <div class="image">
                                <a href="{{$item->getViewUrl()}}"><img src="{{$item->getFeatureImage()}}" alt="{{$item->title}}" /></a>
                            </div>
                            <div class="lower-box">
                                <h3><a href="{{$item->getViewUrl()}}">{{$item->title}}</a></h3>
                                <div class="text">{{$item->getShortDesc(60)}} </div>
                                <a href="{{$item->getViewUrl()}}" class="arrow"><span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                @if($loop->index%2==1 || $loop->last)
                </div>

                @endif

                @endforeach
