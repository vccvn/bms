

                @foreach($list as $item)
                @if($loop->index%2==0)
                <div class="row">
                @endif    
                
                    <!--News Block-->
                    <div class="news-block col-md-6 col-sm-6 col-xs-12">
                        <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <figure class="image-box">
                                <a href="{{$item->getViewUrl()}}"><img src="{{$item->getFeatureImage()}}" alt="{{$item->title}}" /></a>
                                <a class="read-more" href="{{$item->getViewUrl()}}">Đọc tiếp <span class="icon fa fa-long-arrow-right"></span></a>
                            </figure>
                            <div class="lower-content">
                                <div class="upper-box">
                                    <h3><a href="{{$item->getViewUrl()}}">{{$item->title}}</a></h3>
                                    <div class="lower-box">
                                        <div class="date">{{$item->dateFormat('d/m/Y')}} / <a href="{{$item->getViewUrl()}}">{{$item->comment_count?$item->comment_count:0}} bình luận</a></div>
                                    </div>
                                    <div class="text">{{$item->getShortDesc(60)}} </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    
                @if($loop->index%2==1 || $loop->last)
                </div>

                @endif

                @endforeach
