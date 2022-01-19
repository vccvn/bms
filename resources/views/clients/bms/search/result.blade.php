<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
?>
@extends($__layouts.'clean')

@section('title','Tìm kiếm')

@section('header')
    @include($__current.'header')
@endsection

@section('content')
            
            <section class="search-section">
                <div class="search-result">
                    <div class="results">
                        <div class=" about-detail">
                            <h3 class="title-search text-left">Kết quã tìm kiếm cho: <span class="text-danger">{{$search}}</span></h3>
                            <hr class="divider">
                            @if(count($list))
                                <div class="range posts-list row">
                                
                                    @foreach ($list as $item)
                                    <div class="col-sm-6 col-md-12 col-lg-6 mb-4">
                                        <div class="post-item row">
                                            <div class="post-thumb col-md-6 col-lg-12">
                                                <a href="{{$u = $item->getViewUrl()}}">
                                                    <img src="{{$item->getImage()}}" alt="">
                                                </a>
                                                    
                                            </div>
                                            <div class="post-info col-md-6 col-lg-12">
                                                <div class="post-item-title">
                                                    <h4>
                                                        <a href="{{$u}}">{{$item->title}}</a>
                                                    </h4>
                                                    
                                                </div>
                                                <div class="post-item-meta">
                                                    <span><i class="far fa-calendar-alt"></i></span>
                                                    <span>{{$item->calculator_time('created_at')}} </span>
                                                    <span class="ml-2"><i class="fa fa-user"></i></span>
                                                    <span class="p-1">  {{$item->getAuthor()->name}}</span>
                                                </div>
                                                <div class="post-item-desc mt-2">
                                                    {{$item->getShortDesc(120)}}
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
                            
                            
                        </div>
                    </div>
                </div>
            </section>

@endsection