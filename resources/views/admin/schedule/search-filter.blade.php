<?php 
use Illuminate\Support\Facades\Input;
use Cube\Html\Input as HtmlInput;
$keyword = Input::get('s'); 
$perpage = Input::get('perpage'); 
$sortby = Input::get('sortby'); 
$searchby = Input::get('searchby'); 
$sorttype = Input::get('sorttype'); 


$smonth = Input::get('month'); 
$syear = Input::get('year'); 

$sort_list = [''=>'Kiểu sắp xếp','ASC'=>'Tăng dần','DESC'=>'Giảm dần'];
if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$page_sizes = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

if(!isset($search_filter)){
    $search_filter = ['name' => 'têm'];
}elseif(!is_array($search_filter)){
    $search_filter = explode(',', str_replace(' ','',$search_filter));
}

$order_by = array_merge([''=>'Sắp xếp theo...'], $search_filter);
$search_by = array_merge([''=>'Tìm theo...'], $search_filter);

?>

    <div class="card card-block sameheight-item">
        
        <div class="filter-block align-middle">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-xl-5 mr-auto">
                    <form action="" method="get" class="filter-form">
                        <input type="hidden" name="year" value="{{$syear}}">
                        <input type="hidden" name="month" value="{{$syear}}">
                        
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <?php
                                    $search_by = new HtmlInput([
                                        'type' => 'cubeselect',
                                        'name' => 'searchby',
                                        'id' => 'searchby',
                                        'data' => $search_by,
                                        'default' =>$searchby 
                                    ]);
                                ?>
                                {!! $search_by !!}
                            </div>
            
                            <input type="text" class="form-control " name="s" value="{{$keyword}}" placeholder="Tìm kiếm">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary rounded-s" type="submit">
                                    <i class="fa fa-search"></i> 
                                </button>
                            </span>
                        </div>

                        
                    </form>
                </div>
                <!-- end search form -->
                <div class="col-12 col-sm-12 col-md-6 col-xl-4 ml-auto">
                    <form class="" method="post" action="{{route('admin.schedule.create')}}">
                        @csrf
                        @if (($year && $year!='all' ) || ($month && $month!='all'))
                        <input type="hidden" name="year" value="{{$year}}">
                        <input type="hidden" name="month" value="{{$month}}">
                            
                        @endif
                                
                        <div class="input-group">
                            <input type="text" class="form-control boxed rounded-s" name="license_plate" value="" placeholder="Nhập biễn số">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary rounded-s" type="submit">
                                    <i class="fa fa-plus"></i> Thêm
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    
    </div>