<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
$trip_time_types = [
    'direct' => [
        1 => 'Xuất bến (đi)',
        2 => 'Vào bến (về)'
    ],
    'indirect' => [
        1 => 'Ghé bến (đi)',
        2 => 'Ghé bến (về)'
    ],
    'bus' => [
        1 => 'Xuất bến',
        2 => 'Vào bến'
    ]
];
?>

                    <?php if(count($list)): ?>
                        <div class="about-us responsive-table">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhà xe</th>
                                        <th>tuyến xe</th>
                                        <th>Lộ trình</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Giá vé</th>
                                        <th>Liên hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->company_name); ?></td>
                                        
                                        <td>
                                            <?php if($item->direction == 2): ?>
                                                <?php echo e($item->to_station); ?>

                                                <i class="fa fa-long-arrow-right"></i>
                                                <?php echo e($item->from_station); ?>

                                                
                                            <?php else: ?>
                                                <?php echo e($item->from_station); ?>

                                                <i class="fa fa-long-arrow-right"></i>
                                                <?php echo e($item->to_station); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $route = $item->schedule->route;
                                                ?>
                                            <?php if($item->direction == 2): ?>
                                                <?php echo e($item->to_station); ?>,
                                                <?php if($route->reversePlace): ?>
                                                    <?php $__currentLoopData = $route->reversePlace; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($pl->name); ?>,
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <?php echo e($item->from_station); ?>

                                                
                                            <?php else: ?>
                                                <?php echo e($item->from_station); ?>,
                                                <?php if($route->place): ?>
                                                    <?php $__currentLoopData = $route->place; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($pl->name); ?>,
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <?php echo e($item->to_station); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12 col-sm-5">
                                                    <span><?php echo e($trip_time_types[$item->route_type][$item->direction]); ?></span>
                                                </div>
                                                <div class="col-12 col-sm-7">
                                                    <?php if(in_array(get_station_id(), [$item->from_id, $item->from_id])): ?>
                                                        <?php 
                                                        $time = strtotime($item->started_at);
                                                        ?>
                                                        <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('m', $time)); ?></div>
                                                        <div><?php echo e(date('d/m/Y')); ?></div>
                                                    <?php else: ?>
                                                        <?php 
                                                        $time = strtotime($item->arrived_at);
                                                        ?>
                                                        <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('m', $time)); ?></div>
                                                        <div><?php echo e(date('d/m/Y')); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if(in_array(get_station_id(), [$item->from_id, $item->from_id])): ?>
                                                <?php 
                                                $time = strtotime($item->arrived_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('m', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y')); ?></div>
                                            <?php else: ?>
                                                <?php 
                                                $time = strtotime($item->started_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('m', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y')); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!$item->ticket_price): ?>
                                                Dang cập nhật
                                            <?php else: ?>
                                                <?php echo e(number_format($item->ticket_price, 0, ',', '.')); ?>

                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if($item->company_phone_numeber): ?>
                                                <a href="tel:<?php echo e($item->company_phone_numeber); ?>">
                                                    <?php echo e($item->company_phone_numeber); ?>

                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </tbody>
                                
                            </table>    
                        </div>
                        

                    <?php elseif(!$to): ?>
                    <div class="alert alert-info text-center">
                        Hãy chọn điểm đến để tìm chuyến phù hợp với tài chính và thời gian của bạn!
                    </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            Không có chuyến nào
                        </div>
                    <?php endif; ?>
                    