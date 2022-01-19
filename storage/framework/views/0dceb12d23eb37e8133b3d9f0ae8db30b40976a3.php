<?php
use App\Light\Any;

$statistic = new Any($stats);

?>


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
                                    <i class="fa fa-rocket"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_trips(0)); ?> </div>
                                    <div class="name"> lượt xuất bến </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_trips(0)/$statistic->last_month_trips(1)*100)); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-car"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_buses(0)); ?> </div>
                                    <div class="name"> xe hoạt động </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_buses(0)/$statistic->last_month_buses(1)*100)); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-car"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_buses_register(0)); ?> </div>
                                    <div class="name"> xe đăng ký mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_buses_register(0)/$statistic->last_month_buses_register(1)*100)); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_companies(0)); ?> </div>
                                    <div class="name"> nhà xe đăng ký mới </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_companies(0)/$statistic->last_month_companies(1)*100)); ?>%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-road"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_routes(0)); ?> </div>
                                    <div class="name"> tuyến mới mở </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_routes(0)/$statistic->last_month_routes(1)*100)); ?>;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?php echo e($statistic->month_tickets(0)); ?> </div>
                                    <div class="name"> lượt khách </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: <?php echo e(round($statistic->month_tickets(0)/$statistic->last_month_tickets(0)*100)); ?>%;"></div>
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
                                <a class="nav-link active" href="#order-chart-1" role="tab" data-toggle="tab">Xuất bến</a>
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
