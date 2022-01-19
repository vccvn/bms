
@if(count($posts))

        <section class="news-section">
            <div class="auto-container">
                <div class="sec-title">
                    <h2>Tin tức <span class="theme_color">nổi bật</span></h2>
                    <span class="separator"></span>
                </div>

                <div class="row clearfix">
                    <!--News Block-->
                    @foreach($posts as $p)
                    <?php if($loop->index > 1) break; ?>
                    <div class="news-block-three col-md-4 col-sm-6 col-xs-12">
                        <div class="inner-box wow fadeInLeft animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
                            <div class="image-box">
                                <a href="{{$p->getViewUrl()}}"><img src="{{$p->getFeatureImage()}}" alt="{{$p->title}}"></a>
                            </div>
                            <div class="lower-content">
                                <div class="upper-box">
                                    <h2><a href="{{$p->getViewUrl()}}">{{$p->title}}</a></h2>
                                    <!--Separeter Line-->
                                    <div class="separeter-line">
                                        <div class="line-one"></div>
                                    </div>
                                </div>
                                <div class="text">{{$p->getShortDesc(64)}}</div>
                                <div class="date">{{$p->dateFormat('d/m/Y')}} / <a href="{{$p->getViewUrl()}}#comments">{{$p->comment_count?$p->comment_count:0}} Bình luận</a></div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        @foreach($posts as $p)
                        <?php if($loop->index < 2) continue; ?>
                        <!--News Block Two-->
                        <div class="news-block-four">
                            <div class="inner-box">
                                <div class="image-box">
                                    <a href="{{$p->getViewUrl()}}"><img src="{{$p->getFeatureImage('90x90')}}" alt="{{$p->title}}"></a>
                                </div>
                                <!--Title Box-->
                                <div class="title-box">
                                    <h2><a href="{{$p->getViewUrl()}}">{{$p->title}}</a></h2>
                                    <!--Separeter Line-->
                                    <div class="separeter-line">
                                        <div class="line-one"></div>
                                    </div>
                                </div>
                                <div class="text">{{$p->getShortDesc(64)}}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

@endif