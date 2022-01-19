<?php $__env->startSection('title', $profile->name); ?>

<?php $__env->startSection('content'); ?>

<?php 
$genders = ["Nam","Nữ"]; 
?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> <?php echo e($profile->name); ?> </h3>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card items profile-info">
    
        <div class="card card-block sameheight-item">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <p class="text-center">Avatar</p>
                    <p class="avatar-frame text-center"><img src="<?php echo e($profile->getAvatar()); ?>" alt="<?php echo e($profile->name); ?>"></p>
                    <h3 class="text-center"><?php echo e($profile->name); ?></h3>
                </div>
                <div class="col-md-8 col-lg-9 user-info-list">
                    <h3>Thông tin cá nhân</h3>
                    <div class="row">
                        <div class="col-4">Họ tên</div>
                        <div class="col-8"><?php echo e($profile->name); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-4">Giới tính</div>
                        <div class="col-8"><?php echo e($genders[$profile->gender?$profile->gender:0]); ?></div>
                    </div>
                    <div class="row">
                            <div class="col-4">Email</div>
                            <div class="col-8"><?php echo e($profile->email); ?></div>
                        </div>
                        <div class="row">
                                <div class="col-4">Username</div>
                                <div class="col-8"><?php echo e($profile->username); ?></div>
                            </div>
                            <div class="row">
                        <div class="col-4">Số điện thoại</div>
                        <div class="col-8"><?php echo e($profile->phone_number); ?></div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    // window.menusInit = function() {
    //     Cube.menus.init({
    //         urls:{
    //             delete_menu_url: '<?php echo e(route('admin.menu.delete')); ?>'
    //         }
    //     });
    // };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.profile.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>