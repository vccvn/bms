
@extends($__layouts.'single')


@include($__utils.'register-meta')

@section('content')

            <section>
                <div class="container">
                    <div class="contact posts">
                        <div class=" about-detail">
                            <h2 class="title text-left">{{$page_title}}</h2>
                            <hr class="divider">
                            @if(count($list))
                                <div class="range posts-list row">
                                
                                    @foreach ($list as $item)
                        
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
                                
                                </div>

                            
                            {{$list->links('vendor.pagination.bs4')}}

                            @else
                            
                                <div class="alert alert-info">Không có kết quả phù hợp</div>
                            
                            @endif
                            
                            @endsection
                        </div>
                    </div>
                </div>
            </section>