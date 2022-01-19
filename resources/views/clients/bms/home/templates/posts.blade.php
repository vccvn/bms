@if (count($posts))
    
<section class="section-90 section-111 bg-zircon" >
    <div class="container">
        <div class="posts">
            <h2 class="title">Bài viết mới </h2>
            <div class="divider"></div>   
            <div class="range posts-list">
                
                @foreach ($posts as $item)
                    
                <div class="col-md-6 ">
                    <div class="post-item linear">
                        <a href="{{$u = $item->getViewUrl()}}">
                            <img src="{{$item->getImage()}}" alt="">
                        </a>
                        <div class="post-content">
                            <div class="post-tags">
                                @if (count($tags = $item->getTags()))
                                    @foreach ($tags as $tag)
                                    <span>{{$tag->keywords}} </span>
                                    @endforeach
                                @endif
                                
                            </div>
                            <div class="post-body">
                                <div class="post-title">
                                    <h4>
                                        <a href="{{$u}}" class="text-white">{{$item->title}}</a>
                                    </h4>
                                    
                                </div>
                                <div class="post-meta">
                                    <i class="far fa-calendar-alt text-white"></i>
                                    <span>{{$item->calculator_time('created_at')}} </span>
                                    <span class="text-white ml-3">bởi</span>
                                    <span class="p-1"> {{$item->getAuthor()->name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------------- -->

                @endforeach

                <div class="view-all col-12 text-center">
                    <a href="{{route('client.post')}}" class="btn">
                        Xem thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
