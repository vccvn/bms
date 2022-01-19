<?php $__env->startSection('title','Tìm kiếm'); ?>
<?php $__env->startSection('content'); ?>

             <!--Main Slider-->
            <?php echo $__env->make($__current.'templates.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!--End Main Slider-->
            <!--Sidebar Page-->
             <div class="sidebar-page-container right-side-bar">
                <div class="auto-container">
                    <div class="row clearfix">
                        
                        <!--Content Side--> 
                        <div class="content-side col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            
                        <?php if(count($list)): ?>
                            <?php if($current_cate == 'post'): ?>
                                <?php echo $__env->make($__theme.'post.templates.list-style-default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php elseif($current_cate == 'product'): ?>
                                <?php echo $__env->make($__theme.'product.templates.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php elseif($current_cate == 'du-an'): ?>
                                <?php echo $__env->make($__theme.'page.templates.list-style-3', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php elseif($current_cate == 'dich-vu'): ?>
                                <?php echo $__env->make($__theme.'page.templates.list-style-4', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php else: ?>
                                <?php echo $__env->make($__current.'templates.list-style-2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                            <?php echo e($list->links('vendor.pagination.lightsolution')); ?>

                
                        <?php else: ?>
                
                            <div class="alert alert-info">Không có kết quả phù hợp</div>
                
                        <?php endif; ?>
                            
                        </div>
                        <!--Content Side-->
                        
                        <!--Sidebar-->  
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            
                            <?php echo $__env->make($__theme.'_components.sidebar-default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            
                        </div>
                        <!--Sidebar-->  
                        
                    </div>
                </div>
            </div>
            <!-- /.content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make($__theme.'_layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>