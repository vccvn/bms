@extends($__layouts.'main2')
@section('content')

                   <section>
            <div class="container">
                <div class="blog-detail row">
                    <div class="col-md-8 post-detail">
                        <h2 class="post-title">{{$posts->title}}</h2>
                        <div class="info-post">
                            <i class="icon mdi mdi-account rounded-circle"></i>
                            {{$author->getAuthor($posts->user_id)->name}}
                            <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                            Đăng ngày: {{$posts->created_at->format('d/m/Y')}}
                        </div>
                        <div class="post-content">
                            {!! $posts->content !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="adds"></div>
                    </div>
                </div>
            </div>
        </section>

@endsection
