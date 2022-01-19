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
            <form method="POST" action="<?php echo e(route('user.profile.setting.save-general')); ?>" id="setting-general-form" enctype="multipart/form-data" novalidate>
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-md-8">
                        <!-- form group -->
                        <div class="form-group row <?php echo e($errors->has('name')?'has-error':''); ?>" id="form-group-name">
                            <label for="name" class="col-sm-3 form-control-label" id="label-for-name">Họ và tên</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class=" form-control" placeholder="Họ và tên" value="<?php echo e(old('name',$profile->name)); ?>">
                                <?php if($errors->has('name')): ?>
                                <span class="has-error"><?php echo e($errors->first('name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group row <?php echo e($errors->has('password')?'has-error':''); ?>" id="form-group-name">
                            <label for="password" class="col-sm-3 form-control-label" id="label-for-password">Mật khẩu hiện tại</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="password" class=" form-control" placeholder="Mật khẩu hiện tại">
                                <?php if($errors->has('password')): ?>
                                <span class="has-error"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-8 text-center">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <button type="button" class="btn btn-cancel btn-danger">Hủy</button>
                    </div>
                </div>
                
            </form>


        </div>
    </div>
    
</article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    <?php if(session('alert')): ?>
    modal_alert('<?php echo e(session('alert')); ?>');
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.profile.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>