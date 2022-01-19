<?php $__env->startSection('title', 'Chi tiết liên hệ'); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Chi tiết liên hệ </h3>
                </div>
            </div>
        </div>
        <?php echo $__env->make($__templates.'list-search',['search_route'=>'admin.contact.list'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <!-- list content -->
        
    <div class="card items">
        <div class="card card-block">
            <h4><?php echo e($detail->subject?$detail->subject:$detail->name . ' vừa gửi liên hệ'); ?></h4>
            <div class="row mt-3">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Người gửi</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    <?php echo e($detail->name); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Email</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    <?php echo e($detail->email); ?>

                </div>
            </div>
            <?php if($detail->phone_number): ?>
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Số điện thoại</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    <?php echo e($detail->phone_number); ?>

                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>nội dung</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                        <?php echo nl2br($detail->content); ?>

                </div>
            </div>
            
            

            <div class="clearfix replies mt-4">
                <?php $replies = $detail->replies; ?>
                <p><strong>Trả lời (<?php echo e(count($replies)); ?>)</strong></p>
                <?php if(count($replies)): ?>
                    <?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="contact-reply pb-3">
                            <p class="mb-0 pb-0"><strong><?php echo e($rep->author->name); ?></strong></p>
                            <div class="reply-content pl-5"><?php echo nl2br($rep->content); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>

            <div class="reply-form mt-4">
                <form action="<?php echo e(route('admin.contact.send-reply')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="contact_id" value="<?php echo e($detail->id); ?>">
                    <p><strong>Trả lời</strong></p>
                    <?php if(session('success')): ?>
                        <p class="alert alert-success">Bạn đã gửi trả lời thành công</p>
                    <?php elseif(session('fail')): ?>
                        <p class="alert alert-warning">Lỗi bất ngờ vui lòng thử lại</p>
                    <?php endif; ?>
                    <div class="form-group <?php echo e($errors->has('content')?'has-error':''); ?>">
                        <label for="reply-content" class="form-control-label">Nội dung</label>
                        <textarea name="content" id="reply-content" class="form-control"><?php echo e(old('content')); ?></textarea>
                        <?php if($errors->has('content')): ?>
                            <span class="has-error"><?php echo e($errors->first('content')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="buttons">
                        <button type="submit" class="btn btn-primary">Gữi câu trả lời</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</article>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.contact.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .contact-reply{
            border-bottom: 1px silver solid;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>