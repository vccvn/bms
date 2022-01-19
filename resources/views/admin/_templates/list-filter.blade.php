<?php 
use Illuminate\Support\Facades\Input;
$keyword = Input::get('s'); 
$perpage = Input::get('perpage'); 
$sortby = Input::get('sortby'); 
$sorttype = Input::get('sorttype'); 

$sort_list = [''=>'Kiểu sắp xếp','ASC'=>'Tăng dần','DESC'=>'Giảm dần'];
if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$page_sizes = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

if(!isset($filter_list)){
    $filter_list = ['name' => 'têm'];
}elseif(!is_array($filter_list)){
    $filter_list = explode(',', str_replace(' ','',$filter_list));
}

$filter_list = array_merge([''=>'Sắp xếp theo...'], $filter_list);
?>

    <div class="card card-block sameheight-item">
        

        <div class="filter-block align-middle">
            <form action="" method="get" class="filter-form">
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control " name="s" value="{{$keyword}}" placeholder="Tìm kiếm">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="sortby" id="sortby" class="form-control">
                            @foreach($filter_list as $key => $val)
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="{{$v}}" {{strtolower($sortby) == strtolower($v) ? 'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="sorttype" id="sortype" class="form-control">
                            @foreach($sort_list as $k => $vl)
                            <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="perpage" id="perpage" class="form-control">
                            @foreach($page_sizes as $val => $text)
                            <option value="{{$val}}" {{$val == $perpage ? 'selected':''}}>{{$text}}</option>
                            @endforeach
                        </select>
                
                    </div>
                   <div class="col-12 col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Lọc</button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>