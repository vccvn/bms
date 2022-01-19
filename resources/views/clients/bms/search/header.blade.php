<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
$cate = Input::get('cate');
$cate = $cate?$cate:"post";
?>


<div class="page-header" style="background-image: url({{$siteinfo->page_cover_image(theme_asset('images/slide3.jpg'))}});">
        
    <div class="info-page container">
        <h2 class="title-page">
            Tim kiếm
        </h2>
        <div class="list-inline bread-crumb">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 ml-auto mr-auto">
                        <div class="search-form">
                            <form action="{{route('client.search')}}" method="get">
                                @if($cate)
                                <input type="hidden" name="cate" value="{{$cate}}">
                                @endif
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="search" name="s" id="search-input" class="form-control form-control-lg" value="{{$search}}">
                                        
                                        <button type="submit" class="btn btn-warning input-group-btn text-white"><i class="fa fa-search"></i> Tìm kiếm</button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="bread-crumb">
                            @if(isset($cate_list) && $cate_list)
                                @foreach($cate_list as $cate => $text)
                                    @if ($current_cate == $cate)
                                        <li class="breadcrumb-item active">
                                            {{$text}}
                                        </li>

                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{route('client.search',['cate'=>$cate,'s'=>$search])}}">{{$text}}</a>
                                        </li>    
                                    @endif
                                    
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    
</div>



