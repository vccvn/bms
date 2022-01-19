<?php 
use Cube\Html\Input;

$title = 'Lịch trình '.(($year && $year!='all')?(($month && $month!='all'?'tháng '.$month.' ':'cả ') . 'năm '.$year):'');
if(($year && $year!='all' ) && ($month && $month!='all')){
    $prev_month = $month-1;
    if($prev_month<=0){
        $prev_month = 12;
        $prev_year = $year-1;
    }else{
        $prev_year = $year;
    }

    $next_month = $month+1;
    if($next_month==13){
        $next_month = 1;
        $next_year = $year+1;
    }else{
        $next_year = $year;
    }

    
}


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

?>




<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> 
                        <?php if(($year && $year!='all' ) || ($month && $month!='all')): ?>
                            <a href="<?php echo e(route('admin.schedule.list')); ?>" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-long-arrow-left"></i> </a>
                        <?php endif; ?>
                        Lịch trình <?php echo e(($year && $year!='all')?(($month && $month!='all'?'tháng '.$month.' năm ':'cả ') . $year):''); ?>

                        <?php if(($year && $year!='all' )): ?>
                            <?php if($month && $month!='all'): ?>
                            <a href="<?php echo e(route('admin.schedule.list',['year'=>$prev_year, 'month'=>$prev_month])); ?>" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-left"></i> </a>
                            <a href="<?php echo e(route('admin.schedule.list',['year'=>$next_year, 'month'=>$next_month])); ?>" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-right"></i> </a>    
                            <?php else: ?>
                            <a href="<?php echo e(route('admin.schedule.list',['year'=>$year-1])); ?>" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-left"></i> </a>
                            <a href="<?php echo e(route('admin.schedule.list',['year'=>$year+1])); ?>" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-right"></i> </a>    
                                
                            <?php endif; ?>
                            

                        <?php endif; ?>
                        
                    </h3>
                </div>

            </div>
        </div>
        <div class="items-search">
            <form action="" method="get">
                <div class="row">
                    <div class="col-4">
                        <?php echo (new Input([
                                'type' => 'cubeselect',
                                'name' => 'year',
                                'data' => $year_options,
                                'default' => $year,
                                'id' => 'view-year'
                            ])); ?>

                    </div>
                    <div class="col-4">
                        <?php echo (new Input([
                                'type' => 'cubeselect',
                                'name' => 'month',
                                'data' => $month_options,
                                'default' => $month,
                                'id' => 'view-month'
                            ])); ?>

                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Xem
                        </button>
                    </div>
                </div>
            </form>

    
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        <?php echo $__env->make('admin.schedule.search-filter',[
            'search_filter'=>[
                'license_plate' => 'Biển số',
                'route_name' => 'Tên tuyến',
            ]
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($list->count()>0): ?>
        <ul class="item-list striped list-body list-item">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Mã Xe</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-md item-col-title">
                        <div>
                            <span>Biển số</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Tuyến</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Tháng</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Số chuyến</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header fixed item-col-stats item-col-same-sm"> 
                        <div class="text-center">
                            <span>Hành động</span>
                        </div>
                    </div>
                </div>
            </li>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="item" id="item-<?php echo e($item->bus_id); ?>">
                <div class="item-row">
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Mã xe</div>
                        <div class="no-overflow">
                            <span><?php echo e($item->bus_id); ?></span>
                        </div>
                    </div>
                    <div class="item-col fixed pull-left item-col-title item-col-same-md">
                        <div class="item-heading">Biển kiểm soát</div>
                        <div>
                            
                            <h4 class="item-title" id="item-name-<?php echo e($item->bus_id); ?>" data-name="<?php echo e($item->license_plate); ?>"> 
                                <a href="<?php echo e($url = route('admin.schedule.detail',['year'=>$item->year, 'month'=>$item->month, 'license_plate'=>$item->license_clean])); ?>" class=""><?php echo e($item->license_plate); ?> </a>
                            </h4>
                                
                            
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Tuyến</div>
                        <div class="no-overflow">
                            <span><?php echo e($item->route_name); ?></span>
                        </div>
                    </div>
                
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Tháng</div>
                        <div class="no-overflow">
                            <span><?php echo e($item->month); ?>/<?php echo e($item->year); ?></span>
                        </div>
                    </div>
                   
                    <div class="item-col no-overflow item-col-stats item-col-same-sm">
                        <div class="item-heading">Số chuyến</div>
                        <div class="no-overflow">
                            <span><?php echo e($item->trip_total); ?></span>
                        </div>
                    </div>
                        
                    
                    <div class="item-col fixed item-col-stats pull-right item-col-same-sm">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="<?php echo e($url); ?>" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-schedule" data-bus-id="<?php echo e($item->bus_id); ?>" data-month="<?php echo e($item->month); ?>" data-year="<?php echo e($item->year); ?>" title="xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-8">
                    <nav aria-label="Page navigation example" class="text-right">
                        <?php echo e($list->links('vendor.pagination.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
        <?php endif; ?>
        
    </div>

</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.schedulesInit = function(){
        Cube.schedules.init({
            urls:{
                delete_url: '<?php echo e(route('admin.schedule.delete')); ?>'
            }
        });
    };
    
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('js/admin/schedules.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>