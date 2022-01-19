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
            <form method="POST" action="<?php echo e(route('user.profile.setting.save-account')); ?>" id="setting-account-form" enctype="multipart/form-data" novalidate>
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-md-8">
                        <!-- form group -->
                        <?php $__currentLoopData = ['username' => 'Tên truy cập','email' => 'Địa chỉ Email']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group row <?php echo e($errors->has($f)?'has-error':''); ?>" id="form-group-<?php echo e($f); ?>">
                            <label for="<?php echo e($f); ?>" class="col-sm-3 form-control-label" id="label-for-<?php echo e($f); ?>"><?php echo e($t); ?></label>
                            <div class="col-sm-9">
                                <input type="<?php echo e($f=='email'?$f:'text'); ?>" name="<?php echo e($f); ?>" id="<?php echo e($f); ?>" class=" form-control" placeholder="<?php echo e($t); ?>" value="<?php echo e(old($f,$profile->$f)); ?>">
                                <?php if($errors->has($f)): ?>
                                <span class="has-error"><?php echo e($errors->first($f)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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