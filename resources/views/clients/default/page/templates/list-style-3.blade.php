
                @foreach($list as $item)
                @if($loop->index%2==0)
                <div class="row">
                @endif    
                    <!--News Block-->
                    <div class="news-block-three col-md-6 col-sm-6 col-xs-12">
                        <div class="inner-box wow fadeInLeft animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
                            <div class="image-box">
                                <a href="{{$item->getViewUrl()}}"><img src="{{$item->getFeatureImage()}}" alt="{{$item->title}}" /></a>
                            </div>
                            <div class="lower-content">
                                <div class="upper-box">
                                    <h2><a href="{{$item->getViewUrl()}}">{{$item->title}}</a></h2>
                                    <!--Separeter Line-->
                                    <div class="separeter-line">
                                        <div class="line-one"></div>
                                    </div>
                                </div>
                                <div class="text">{{$item->getShortDesc(60)}} </div>
                                <div class="date">{{$item->dateFormat('d/m/Y')}} / <a href="{{$item->getViewUrl()}}">{{$item->comment_count?$item->comment_count:0}} bình luận</a></div>
                                
                            </div>
                        </div>
                    </div>


                    
                @if($loop->index%2==1 || $loop->last)
                </div>

                @endif

                @endforeach
