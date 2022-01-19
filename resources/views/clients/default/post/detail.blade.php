@extends($__layouts.'sidebar')


@include($__utils.'register-meta')

@section('content')

                    <!--News details-->
                    <div class="blog-detail">
						
                        <!--News Block-->
                        <div class="news-block">
                            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <figure class="image-box">
                                    <img src="{{$article->getFeatureImage()}}" alt="" />
                                </figure>
                                <div class="lower-content">
                                    <div class="upper-box">
                                        <h3>{{$article->title}}</h3>
                                        <div class="lower-box">
                                            <div class="date"><i class="fa fa-calendar"></i> {{$article->dateFormat('d-m-Y')}} / <a href="{{$article->category->getViewUrl()}}"> <i class="fa fa-folder-open"></i> {{$article->category->name}}</a> / <a href="#comments"><i class="fa fa-comment"></i> {{$article->comment_count?$article->comment_count:0}} bình luận</a></div>
                                        </div>
                                        <div class="text">{!! $article->content !!}</div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <!--Post Share Options-->
                            <div class="post-share-options clearfix">
                                @include($__templates.'post-tags',['tags'=>$article->getTags()])
                            </div>
                        </div>
                        {{-- nut like --}}
                        @include($__utils.'social-buttons', [
                            'link'=>$article->getViewUrl(),
                            'title' => $article->title
                        ])

                    	<!--Comments Area-->
                        @include($__templates.'comments',[
                            'comments'=>$article->publishComments,
                            'object' => $article->type,
                            'object_id' => $article->id,
                            'link' => $article->getViewUrl()
                        ])
                   		

                   	</div>
                

@endsection
