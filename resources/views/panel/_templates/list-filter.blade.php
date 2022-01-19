<?php 
use Illuminate\Support\Facades\Input;
$keyword = Input::get('s'); 
$perpage = Input::get('perpage'); 
$sortby = Input::get('sortby'); 
$sorttype = Input::get('sorttype'); 
$sort_list = ['ASC'=>'Tăng dần','DESC'=>'Giảm dần'];
if(strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$perpages = [10,25,50];

if(!isset($filter_list)){
    $filter_list = ['name' => 'têm'];
}elseif(!is_array($filter_list)){
    $filter_list = explode(',', str_replace(' ','',$filter_list));
}
?>

    <div class="card card-block sameheight-item">
        <div class="filter-block align-middle">
            <form action="" method="get" class="filter-form">
                @if($keyword)
                    <input type="hidden" name="s" value="{{$keyword}}">
                @endif
                <h4>Bộ lọc</h4>
                <div class="form-group row">
                    <div class="col-sm-6 col-md-3">
                        <div class="row">
                            <div class="col-5">
                                <label for="sortby">lọc theo</label>
                            </div>
                            <div class="col-7">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="sorttype">Kiểu sắp xếp</label>
                            </div>
                            <div class="col-6">
                                <select name="sorttype" id="sortype" class="form-control">
                                    @foreach($sort_list as $k => $vl)
                                    <option value="{{$k}}" {{strtoupper($sorttype) == $k ? 'selected':''}}>{{$vl}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="perpage">Số KQ / trang</label>
                            </div>
                            <div class="col-6">
                                <select name="perpage" id="perpage" class="form-control">
                                    @foreach($perpages as $val)
                                    <option value="{{$val}}" {{$val == $perpage ? 'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                   <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Lọc</button>
                    </div>
                </div>
            </form>
        </div>
    </div>