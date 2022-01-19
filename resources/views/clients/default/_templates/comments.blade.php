<style>
    .comments-section{
        margin: 50px auto;
    }
    .facebook-comments{
        margin-top: 10px;
        margin-bottom: 10px;
        position: relative;
    }

</style>


    
                       <section class="comments-section">
                            <div class="comments-wrapper">
                                <ul class="post-filter text-left list-inline diferent-choose">
                                    <li class="active" data-filter=".web-comment">
                                        <span>{{$siteinfo->site_name}}</span>
                                    </li>
                                    <li data-filter=".facebook-comment">
                                            <span>Facebook</span>
                                        </li>
                                        
                                </ul>
                                <div class="bs4-row clearfix masonary-layout filter-layout">
                                    <div class="facebook-comment col-12">
                                        
                                        <?php
                                        $u = isset($url)?$url:(isset($link)?$link:'');
                                        $w = isset($width)?$width:'100%';
                                        $n = isset($show)?$show:'10';
                                        ?>
                                        <div class="facebook-comments position-relative">
                                            <div 
                                                class="fb-comments" 
                                                data-href="{{$u}}" 
                                                data-width="{{$w}}" 
                                                data-numposts="{{$n}}"
                                            ></div>
                                        </div>
                                    </div>
                                        
                                    <!--Default Portfolio Item-->
                                    <div class="web-comment col-12 col-sm-12">
                                        
                                        <div class="comments-area" id="comments">
                                            @if($comments)
                                                <div class="group-title"><h2>{{count($comments)}} bình luận</h2></div>
                                                @foreach($comments as $c)
                                                    <?php 
                                                    $user = $c->user(); 
                                                    $replies = $c->replies;
                                                    ?>
                
                                                    <!--Comment Box-->
                                                    <div class="comment-box">
                                                        <div class="comment">
                                                            <div class="author-thumb"><img src="{{$user->getAvatar()}}" alt="{{$user->name}}"></div>
                                                            <div class="comment-inner">
                                                                <div class="comment-info clearfix"><strong>{{$user->name}}</strong><br><div class="comment-time">{{$c->dateFormat('d-m-Y')}}</div></div>
                                                                <div class="text">{!! nl2br($c->content) !!}</div>
                                                                <a class="comment-reply" data-id="{{$c->id}}" href="#">Trả lời</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($replies)
                                                        @foreach($replies as $rep)
                                                            <?php 
                                                            $u = $rep->user(); 
                                                            $reps = $rep->replies;
                                                            ?>
                                                            <!--Reply Comment Box-->
                                                            <div class="comment-box reply-comment">
                                                                <div class="comment">
                                                                    <div class="author-thumb"><img src="{{$u->getAvatar()}}" alt="{{$u->name}}"></div>
                                                                    <div class="comment-inner">
                                                                        <div class="comment-info clearfix"><strong>{{$u->name}}</strong><br><div class="comment-time">{{$rep->dateFormat('d-m-Y')}}</div></div>
                                                                        <div class="text">{!! nl2br($rep->content) !!}</div>
                                                                        <a class="comment-reply" data-id="{{$rep->id}}" href="#">Trả lời</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                
                                                            @if($reps)
                                                                @foreach($reps as $re)
                                                                    <?php 
                                                                    $usr = $re->user(); 
                                                                    ?>
                                                                    <!--Reply Comment Box-->
                                                                    <div class="comment-box reply-comment">
                                                                        <div class="comment">
                                                                            <div class="author-thumb"><img src="{{$usr->getAvatar()}}" alt="{{$usr->name}}"></div>
                                                                            <div class="comment-inner">
                                                                                <div class="comment-info clearfix"><strong>{{$usr->name}}</strong><br><div class="comment-time">{{$re->dateFormat('d-m-Y')}}</div></div>
                                                                                <div class="text">{!! nl2br($re->content) !!}</div>
                                                                                <a class="comment-reply" data-id="{{$re->id}}" href="#">Trả lời</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="comment-form wow fadeInUp" id="leave-comment-form" data-wow-delay="200ms" data-wow-duration="1500ms">
                                            <div class="group-title"><h2>Để lại ý kiến của bạn</h2></div>
                                            <!--Comment Form-->
                                            <form method="post" action="{{route('client.comment.save')}}" novalidate>
                                                {{csrf_field()}}
                                                <input type="hidden" name="object" value="{{$object}}" class="cmt-input">
                                                <input type="hidden" name="object_id" value="{{$object_id}}" class="cmt-input">
                                                <div class="row clearfix">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input type="text" name="name" placeholder="Họ và Tên" class="cmt-input">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input type="email" name="email" placeholder="Email" class="cmt-input">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                        <textarea name="content" placeholder="Nội dung" class="cmt-input"></textarea>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                        <button class="theme-btn btn-style-one" type="submit" name="submit-form">Gửi</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </section>