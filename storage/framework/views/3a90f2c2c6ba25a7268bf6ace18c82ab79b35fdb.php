<?php $__env->startSection('title', '404 - không tìm thấy trang'); ?>

<?php $__env->startSection('content'); ?>

	<!--Error Section-->
	<section class="error-section">
            <div class="auto-container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <figure class="image-box">
                            <img src="<?php echo e(get_theme_url('images/resource/error-image.png')); ?>" alt="" />
                        </figure>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="content">
                            <div>
                                <h3>Rất tiếc! Trang bạn yêu cầu hiện không có <br><span class="theme_color">Error 404!</span></h3>
                                <div class="text">Can't find what you need? Take a moment and do a search <br> below or start from our <a href="index-2.html">homepage.</a></div>
                                
                                <!--Search The Website-->
                                <div class="search-website">
                                    <form method="get" action="<?php echo e(route('client.search')); ?>">
                                        <div class="form-group">
                                            <input type="search" name="s" value="" required placeholder="Nhập tên mục bãn muốn tìm kiếm">
                                            <button type="submit" class="theme-btn">Tìm kiếm</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                                
                    </div>
                </div>
                
            </div>
        </section>
        <!--Error Section-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'fullwidth-page-title', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>