<?php
use Cube\Html\Input as HtmlInput;
$day_options = [];
$year_options = [
];
$month_options = [
];
$day_options = [
];
$max_year = date('Y')+5;
for($i = 2017; $i <= $max_year; $i++){
    $year_options[$i] = 'Năm '.$i;
}
for ($i=1; $i < 13; $i++) { 
    $month_options[$i] = 'Tháng '.$i;
}

for ($i=1; $i < 32; $i++) { 
    $day_options[$i] = 'Ngày '.$i;
}



?>

<?php $__env->startSection('title', 'Check In / Check Out'); ?>

<?php $__env->startSection('content'); ?>

    <div class="auth trip-checkio">
        <div class="auth-container">
            <div class="card">
                <header class="auth-header">
                    <h1 class="auth-title">
                        <div class="logo">
                            <span class="l l1"></span>
                            <span class="l l2"></span>
                            <span class="l l3"></span>
                            <span class="l l4"></span>
                            <span class="l l5"></span>
                        </div> BMS | Check-in / Check-out </h1>
                </header>
                <div class="auth-content">
                    <form action="<?php echo e(route('admin.log.search')); ?>" method="post" id="checkin-form" novalidate>
                        <div class="form-group text-center">
                            <label class="pr-4">
                                <input type="radio" name="action" value="started" checked /> Xuất bến 
                            </label>
                            <label>
                                <input type="radio" name="action" value="arrived" /> Vào bến
                            </label>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend input-group-addon">
                                <label for="license_plate" class="input-group-text mb-0">
                                    <i class="fa fa-tag"></i>
                                    Biển số
                                </label>
                            </div>
                            <input type="text" name="license_plate" id="license_plate" class="form-control text-center" placeholder="Nhập biển số" autocomplete="false" />
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                            </div>
                        </div>
                        
                    
                    </form>
                    <div class="trip-result"></div>

                </div>
            </div>
            <div class="text-center">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Dashboard 
                </a>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('jsinit'); ?>

    <script>
        window.checkioInit = function() {
            Cube.checkio.init({
                urls:{
                    checkin_url:  '<?php echo e(route('admin.log.check')); ?>',
                    checkout_url:  '<?php echo e(route('admin.log.check')); ?>',
                    cancel_url:  '<?php echo e(route('admin.log.cancel')); ?>',
                    change_status_url:  '<?php echo e(route('admin.trip.status')); ?>'
                }
            });
        };
    </script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

    <?php echo $__env->make($__templates.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('js/admin/checkio.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/log.css')); ?>">
<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'clean', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>