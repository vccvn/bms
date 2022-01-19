@if($services && $servs = $services->getChildren(['@order_by'=>['created_at'=>'DESC'], '@limit'=>3]))

        <section class="welcome-section">
            <div class="auto-container">
                <div class="sec-title center">
                    <h2>Các dịch vụ của <span class="theme_color">Light Solution</span></h2>
                    <span class="separator"></span>
                </div>
                <div class="row clearfix">
                    @foreach($servs as $serv)
                    <!--Service Block-->
                    <div class="column col-md-4 col-sm-6 col-xs-12">
                        <div class="service-block-eight">
                            <div class="inner-box">
                                <div class="image-box">
                                    <img src="{{$serv->getFeatureImage()}}" alt="{{$serv->title}}">
                                    <div class="caption">{{$serv->title}}</div>
                                    <div class="overlay-box">
                                        <h3>{{$serv->title}}</h3>
                                        <div class="text">{{$serv->getShortDesc(60)}}</div>
                                        <a class="read-more" href="{{$serv->getViewUrl()}}">Chi tiết <span class="fa fa-angle-double-right"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
                <div class="row clearfix">
                    <div class="col-xs-12 col-lg-12 text-center">
                        <a href="{{$services->getViewUrl()}}" class="theme-btn btn-style-one">Xem thêm</a>
                    </div>
                </div>
            </div>
        </section>

@endif