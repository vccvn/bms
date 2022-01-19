<?php 
use Illuminate\Support\Facades\Input;
$keyword = Input::get('s'); 
$perpage = Input::get('perpage'); 
$sortby = Input::get('sortby'); 
$sorttype = Input::get('sorttype'); 
$from_date = Input::get('from_date'); 
$to_date = Input::get('to_date'); 
$sort_list = [""=>"Kiểu sắp xếp", 'ASC'=>'Tăng dần','DESC'=>'Giảm dần'];
if($sorttype && strtolower($sorttype)!='desc'){
    $sorttype = 'ASC';
}
$perpages = [""=>"KQ / trang", 10 => 10, 25 => 25,50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000];

if(!isset($filter_list)){
    $filter_list = ['city' => 'Thành phố'];
}elseif(!is_array($filter_list)){
    $filter_list = explode(',', str_replace(' ','',$filter_list));
}

$filter_list = array_merge(['' => "Lọc theo..."], $filter_list);
?>

    <div class="card card-block sameheight-item mb-0">
        <div class="filter-block align-middle">
            <form action="" method="get" class="filter-form">
                <?php if($keyword): ?>
                    <input type="hidden" name="s" value="<?php echo e($keyword); ?>">
                <?php endif; ?>
                <h4>Bộ lọc</h4>
                <div class="form-group row mb-0">
                    <div class="col-sm-6 col-md-2">
                        <div class="input-group date" id="datepicker-from">
                            <input type="text" class="form-control filter-date" name="from_date" value="<?php echo e($from_date); ?>" placeholder="Từ ngày...">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <div class="input-group date" id="datepicker-to">
                            <input type="text" class="form-control filter-date" name="to_date" value="<?php echo e($to_date); ?>" placeholder="đến ngày">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
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
                            <?php $__currentLoopData = $perpages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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