@extends($__layouts.'main2')
@section('content')
<section>
            <div class="container">
                <div class="contact posts row">
                    <div class=" about-detail">
                        <h2 class="title text-left">Bài viết</h2>
                        <hr class="divider">
                        <div class="range posts-list">
                            @foreach($posts as $key => $value)
                        <div class="col-md-6">
                            <div class="post-item">
                                <img src="{{$value->getImage()}}" alt="">
                                <div class="post-content">
                                    <div class="post-tags">
                                        <span>Tin tức </span>
                                    
                                    </div>
                                    <div class="post-body">
                                        <div class="post-title">
                                            <a href="{{url('tin-tuc/'.$value->slug)}}">
                                                <h4> {{ $value->title}} </h4>
                                            </a>
                                        </div>
                                        <div class="post-meta">
                                            <i class="far fa-calendar-alt text-white"></i>
                                            <span> {{ $value->created_at->format('d/m/Y')}} </span>
                                            <span class="text-white ml-3">bởi</span>
                                            <span class="p-1">{{ $author->getAuthor($value->user_id)->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach 
                           <!-------------------------- -->
                       
                       <!-------------------------- -->
                            <nav class="mt-5">
                                <ul class="pagination pagination-lg">
                                    <li class="page-item disabled ">
                                        <a class="page-link " href="#" tabindex="-1">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endsection