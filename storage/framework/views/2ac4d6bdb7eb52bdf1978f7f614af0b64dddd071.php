<?php $__env->startSection('title', '404 - không tìm thấy trang'); ?>

<?php $__env->startSection('content'); ?>

	<!--Error Section-->
	<section class="error-section" style="margin-top: 80px; margin-bottom: 80px">
        <div class="container">
            <div class="content">
                <div class="text-center">
                    <h3>Rất tiếc! Trang bạn yêu cầu hiện không có <br><span class="theme_color">Error 404!</span></h3>
                    <div class="text">Can't find what you need? Take a moment and do a search <br> below or start from our <a href="index-2.html">homepage.</a></div>
                    
                    <!--Search The Website-->
                    <div class="search-website mt-5 row">
                        <div class="col-md-8 col-xl-6 ml-auto mr-auto">
                            <form method="get" action="<?php echo e(route('client.search')); ?>">
                                <div class="form-group">
                                    <input type="search" name="s" class="form-control" required placeholder="Nhập tên mục bãn muốn tìm kiếm">
                                    <div class="input-group-btn">
                                        <button type="submit" class="theme-btn btn btn-default">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Error Section-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'single', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>