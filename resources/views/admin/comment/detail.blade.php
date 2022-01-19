<?php
    $post = $detail->post();
    $product = $detail->product();
    $page = $detail->page();
    
    $info = $post?["Bài viết", $post->getViewUrl(), $post->title]:(
        $product?["Sản phẩm", $product->getViewUrl(), $product->name]:(
            $page?["Trang", $page->getViewUrl(), $page->title]:[null, null, null]
        )
    );
?>
@extends($__layouts.'main')

@section('title', 'Phản hồi')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Phản hồi </h3>
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.post.list'])
    </div>
    <!-- list content -->
        
    <div class="card items">
        <div class="card card-block">
            <h4>{{$detail->title()}}</h4>
            <div class="row mt-3">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Người gửi</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->author_name}}
                </div>
            </div>

            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Điện thoại</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->author_phone}}
                </div>
            </div>
            @if($detail->author_email)
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Email</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->author_email}}
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>nội dung</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {!! nl2br($detail->content) !!}
                </div>
            </div>
            @if($info[0])
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>{{$info[0]}}</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    <a href="{{$info[1]}}">{{$info[2]}}</a>
                </div>
            </div>
            @endif
                       
        </div>
    </div>
    
</article>

@endsection


@section('jsinit')
<script>
    window.commentsInit = function() {
        Cube.comments.init({
            urls:{
                delete_url: '{{route('admin.comment.delete')}}'
            }
        });
    };
</script>
@endsection
@section('js')
<script src="{{asset('js/admin/comments.js')}}"></script>
@endsection