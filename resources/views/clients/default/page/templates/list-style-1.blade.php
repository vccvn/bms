
                    @foreach($list as $item)

                    <!--News Block Two-->
                    <div class="news-block-two wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="inner-box clearfix">
                            <figure class="image-box">
                                <img src="{{$item->getFeatureImage()}}" alt="{{$item->title}}" />
                            </figure>
                            <div class="content-box">
                                <div class="upper-box">
                                    <h3><a href="{{$item->getViewUrl()}}">{{$item->title}}</a></h3>
                                    <div class="text">{{$item->getShortDesc(60)}}</div>
                                </div>
                                <div class="lower-box">
                                    <div class="date"><i class="fa fa-calendar"></i> {{$item->dateFormat('d/m/Y')}} / <a href="{{$item->getViewUrl()}}"><i class="fa fa-comment"></i> {{$item->comment_count?$item->comment_count:0}} bình luận</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
