

                        <aside class="sidebar blog-sidebar">

                            <!-- Search Form -->
                            <div class="sidebar-widget search-box">
                                <div class="sidebar-title"><h2>Tìm kiếm</h2></div>
                                <form method="get" action="{{route('client.search')}}">
                                    <div class="form-group">
                                        <input type="search" name="s" value="" placeholder="Nhập từ khóa">
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>
                            

                            @if(count($categories = get_pupular_category_list()))

                            <!-- Categories -->
                            <div class="sidebar-widget recent-articles wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Chuyên mục</h2></div>
                                <ul class="list">
                                    @foreach($categories as $cate)
                                    <li><a href="{{$cate->getViewUrl()}}" class="clearfix">{{$cate->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            @endif
                            
                            @if(count($posts = get_post_list(['@order_by'=>['created_at'=>'DESC'],'@limit'=>6])))

                            <!-- Popular Posts -->
                            <div class="sidebar-widget popular-posts wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Bài viết gần đây</h2></div>
                                @foreach($posts as $p)

                                <article class="post">
                                    <figure class="post-thumb"><a href="{{$p->getViewUrl()}}"><img src="{{$p->getFeatureImage('90x90')}}" alt="{{$p->title}}"></a></figure>
                                    <h4><a href="{{$p->getViewUrl()}}">{{$p->title}}</a></h4>
                                    <div class="post-info">{{$p->dateFormat('d/m/Y')}} / <a href="{{$p->getViewUrl()}}">{{$p->comment_count?$p->comment_count:0}} Bình luận</a></div>
                                </article>
                                
                                @endforeach
                                
                            </div>
                            @endif

                            @if($tags = get_popular_tags(['@limit'=>6]))
                            <!-- Tags -->
                            <div class="sidebar-widget popular-tags wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="sidebar-title"><h2>Từ khóa nổi bật</h2></div>
                                @foreach($tags as $tag)

                                <a href="{{route('client.search',['s'=>$tag->lower])}}">{{$tag->keywords}}</a>

                                @endforeach
                            </div>
                            
                            @endif
                        </aside>

                        