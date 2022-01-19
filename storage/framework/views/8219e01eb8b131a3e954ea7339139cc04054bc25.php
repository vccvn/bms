    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-6 col-xl-5 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title"> Số liệu trong tháng <?php echo e(date('m')); ?></h4>
                        </div>
                        <div class="row row-sm stats-container">
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-file-o"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['post_month_total']); ?> </div>
                                    <div class="name"> Tin bài mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e($stats['post_total']?round($stats['post_month_total']/$stats['post_total']*100):100); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-folder-o"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['category_month_total']); ?> </div>
                                    <div class="name"> Danh mục mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e($stats['category_total']?round($stats['category_total']/$stats['category_total']*100):100); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-leaf"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['product_month_total']); ?> </div>
                                    <div class="name"> Sản phẩm mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e($stats['product_total']?round($stats['product_total']/$stats['product_total']*100):100); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-comment"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['comment_month_total']); ?> </div>
                                    <div class="name"> Số phản hồi </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e($stats['comment_total']?round($stats['comment_month_total']/$stats['comment_total']*100):100); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-eye"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['view_total']); ?> </div>
                                    <div class="name"> Tổng lượt xem </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($stats['user_month_total']); ?> </div>
                                    <div class="name"> Người dung mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e($stats['user_total']?round($stats['user_month_total']/$stats['user_total']*100):100); ?>%;"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-12 col-md-6 col-xl-7 order-col">
                <div class="card sameheight-item" data-exclude="xs" id="dashboard-order">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h3 class="title">Biểu đồ</h3>
                        </div>
                        <ul class="nav nav-tabs pull-right" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#order-chart-1" role="tab" data-toggle="tab">Phản hồi</a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active fade show" id="order-chart-1">
                                <p class="title-description"> Thống kê trong vòng 1 tuần trở lại đây </p>
                                <div id="monthly-orders-chart"  class="flot-chart-content" ></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->startSection('css'); ?>
    <style>
        #monthly-orders-chart{
            width: 100%;
            height: 220px;
        }
    </style>
<?php $__env->stopSection(); ?>
