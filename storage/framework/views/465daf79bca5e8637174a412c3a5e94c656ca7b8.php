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
                            <input type="text" class="form-control " name="s" value="<?php echo e($keyword); ?>" placeholder="Tìm kiếm">
                            
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="sortby" id="sortby" class="form-control">
                            <?php $__currentLoopData = $filter_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(is_numeric($key)){
                                    $v = $val;
                                }else{
                                    $v = $key;
                                }
                            ?>
                            <option value="<?php echo e($v); ?>" <?php echo e(strtolower($sortby) == strtolower($v) ? 'selected':''); ?>><?php echo e($val); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="sorttype" id="sortype" class="form-control">
                            <?php $__currentLoopData = $sort_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $vl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>" <?php echo e(strtoupper($sorttype) == $k ? 'selected':''); ?>><?php echo e($vl); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="perpage" id="perpage" class="form-control">
                            <?php $__currentLoopData = $page_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e($val == $perpage ? 'selected':''); ?>><?php echo e($text); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                
                    </div>
                   <div class="col-12 col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Lọc</button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>