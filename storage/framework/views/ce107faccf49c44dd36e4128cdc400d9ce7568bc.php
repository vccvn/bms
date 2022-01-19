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
$year_options = [
    '' => 'Năm',
    'all' => 'Tất cả'
];
$month_options = [
    '' => 'Tháng',
    'all' => 'Cả năm'
];
$max_year = date('Y')+5;
for($i = 2017; $i <= $max_year; $i++){
    $year_options[$i] = $i;
}
for ($i=1; $i < 13; $i++) { 
    $month_options[$i] = 'Tháng '.$i;
}


$day_options = [
    '' => 'Ngày',
    'all' => 'Cả tháng'
];
for ($i=1; $i < 32; $i++) { 
    $day_options[$i] = $i;
}



?>

    <div class="card card-block sameheight-item">
        
        <div class="filter-block align-middle">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-5 col-xl-5 mr-auto">
                    <form action="" method="get" class="filter-form">
                        <input type="hidden" name="year" value="<?php echo e($syear); ?>">
                        <input type="hidden" name="month" value="<?php echo e($month); ?>">
                        
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
                                <?php echo $search_by; ?>

                            </div>
            
                            <input type="text" class="form-control " name="s" value="<?php echo e($keyword); ?>" placeholder="Tìm kiếm">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary rounded-s" type="submit">
                                    <i class="fa fa-search"></i> 
                                </button>
                            </span>
                        </div>

                        
                    </form>
                </div>
                <!-- end search form -->
                <div class="col-12 col-sm-12 col-md-7 col-xl-6 ml-auto">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-3 pr-1">
                                <?php echo (new HtmlInput([
                                        'type' => 'cubeselect',
                                        'name' => 'year',
                                        'data' => $year_options,
                                        'default' => $year,
                                        'id' => 'view-year',
                                        'class' => 'disable-search' 
                                    ])); ?>

                            </div>
                            <div class="col-3 pl-0 pr-1">
                                <?php echo (new HtmlInput([
                                        'type' => 'cubeselect',
                                        'name' => 'month',
                                        'data' => $month_options,
                                        'default' => $month,
                                        'id' => 'view-month',
                                        'class' => 'disable-search' 
                                    ])); ?>

                            </div>
                            <div class="col-3 pl-0 pr-1">
                                <?php echo (new HtmlInput([
                                        'type' => 'cubeselect',
                                        'name' => 'day',
                                        'data' => $day_options,
                                        'default' => $day,
                                        'id' => 'view-day',
                                        'class' => 'disable-search' 
                                    ])); ?>

                            </div>
                            
                            <div class="col-3 pl-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Xem
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    
    </div>