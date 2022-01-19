
<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
$cate = Input::get('cate');
$cate = $cate?$cate:"post";
?>

<section class="page-title" style="background-image: url({{get_theme_url('images/background/4.jpg')}});">
    <div class="auto-container">
        <div class="row">
            <div class="col-sm-8">
                <div class="search-form">
                    <form action="{{route('client.search')}}" method="get">
                        @if($cate)
                        <input type="hidden" name="cate" value="{{$cate}}">
                        @endif
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" name="s" id="search-input" class="form-control form-control-lg" value="{{$search}}">
                                <span class="input-group-btn input-append">
                                    <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i> Tìm kiếm</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="bread-crumb">
                    @if(isset($cate_list) && $cate_list)
                        @foreach($cate_list as $cate => $text)
                            <li><a href="{{route('client.search',['cate'=>$cate,'s'=>$search])}}" class="{{$current_cate == $cate ? "theme_color": ""}}">{{$text}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</section>

