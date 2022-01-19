<?php 
$category = isset($parent)?$parent:null;
$layout = ($article->layout && in_array($article->layout, ['single', 'sidebar']))?$article->layout:'sidebar';

?>
@extends($__layouts.$layout)

@include($__utils.'register-meta')

@section('content')

@if ($layout!='sidebar')
    @if ($article->display_content)
        {!! $article->content !!}
    @else
    <div class="container-fluid">

        <div class="blog-detail">
            <div class="post-detail">
                <h2 class="post-title font-weight-bold">{{$article->title}}</h2>
                <div class="info-post">
                    <i class="icon mdi mdi-account rounded-circle"></i>
                    Đăng bởi: {{$article->getAuthor()->name}}
                    <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                    Đăng ngày: {{$article->dateFormat('d.m.Y')}}
                </div>
                <div class="post-content">
                    {{$article->description}}
                    <img src="{{$article->getImage()}}" alt="">
                    <div class="detail-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    @endif    
@else
    @if ($article->display_content)
    {!! $article->content !!}
    @else
        
    <div class="blog-detail">
        <div class="post-detail">
            <div class="thumb">
                    <img src="{{$article->getImage()}}" alt="{{$article->slug}}">
            </div>
            <h2 class="post-title font-weight-bold">{{$article->title}}</h2>
            <div class="info-post">
                <i class="icon mdi mdi-account rounded-circle"></i>
                Đăng bởi: {{$article->getAuthor()->name}}
                <i class="icon mdi mdi-calendar-multiselect rounded-circle"></i>
                Đăng ngày: {{$article->dateFormat('d.m.Y')}}
            </div>
            <div class="post-content">
                
                <div class="detail-content">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </div>
    @endif
@endif


@endsection