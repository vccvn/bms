<?php $__env->startSection('title', 'Danh mục'); ?>

<?php $__env->startSection('content'); ?>

<div class="auth">
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
                        </div> BMS </h1>
                </header>
                <div class="auth-content">
                    <p class="text-center">Vui lòng đăng nhập biển số</p>
    


                    <form id="checkin-form" method="POST" action="<?php echo e(route('admin.log.search')); ?>" novalidate="true">
                
                        <div class="form-group" id="form-group-license_plate">
                            <label for="license_plate" class="form-control-label" id="label-for-license_plate">Biển số</label>
                            <input type="text" name="license_plate" id="license_plate" class="form-control underlined" placeholder="Nhập biển số" />
                        </div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button> </div>
                    </form>
                    <div class="trip-result"></div>

                </div>
            </div>
            <div class="text-center">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Dashboard 
                </a>

                <a href="javascript:void();" class="btn btn-primary btn-sm">
                    <i class="fa fa-inbox"></i> Check In 
                </a>

                <a href="http://bms.chinhlatoi.vn" class="btn btn-secondary btn-sm">
                    <i class="fa fa-outdent"></i> Check Out
                </a>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('js'); ?>

    <?php echo $__env->make($__templates.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('js/admin/logs.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'clean', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>