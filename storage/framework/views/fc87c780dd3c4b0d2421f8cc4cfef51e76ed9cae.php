<?php if($trip): ?>
<?php
$route = $trip->schedule->route;
$st = ($route->type == 'direct' || ($route->type=='bus' && in_array($__setting->station_id, [$route->from_id, $route->to_id])));
$trip_time_types = [
    'direct' => 'Xuất bến',
    'indirect' => 'Ghé bến',
    'bus' => 'Xuất bến',
];

$trip_time_types2 = [
    'direct' => [
        1 => 'Đến nơi',
        2 => 'Vào bến'
    ],
    'indirect' => [
        1 => 'Xuất bến',
        2 => 'Xuất bến'
    ],
    'bus' => [
        1 => 'Xuất bến',
        2 => 'Vào bến'
    ]
];


?>
<table class="trip-detail-table">
    <thead>
        <th>
            Thông tin
        </th>
        <th>
            Chi tiết
        </th>
    </thead>
    <tbody>
        
    <tr>
        <td>Biển số</td>
        <td><?php echo e($trip->license_plate); ?></td>
    </tr>

    <tr>
        <td>Nhà xe</td>
        <td><?php echo e($trip->company_name); ?></td>
    </tr>

    <tr>
        <td>Hướng đi</td>    
        <td>
            <?php if($trip->direction == 2): ?>
                <?php echo e($trip->to_station); ?>

                -
                <?php echo e($trip->from_station); ?>

                
            <?php else: ?>
                <?php echo e($trip->from_station); ?>

                -
                <?php echo e($trip->to_station); ?>

            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Lộ trình</td>
        <td>
            
            <?php if($trip->direction == 2): ?>
                Bến xe <?php echo e($trip->to_station); ?> - 
                <?php if($route->reversePlace): ?>
                    <?php $__currentLoopData = $route->reversePlaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($pl->place_name); ?> - 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                Bến xe <?php echo e($trip->from_station); ?>

                
            <?php else: ?>
                Bến xe <?php echo e($trip->from_station); ?> - 
                <?php if($route->places): ?>
                    <?php $__currentLoopData = $route->places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($pl->place_name); ?> - 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                Bến xe <?php echo e($trip->to_station); ?>

            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>
            <?php echo e($trip_time_types[$trip->route_type]); ?>

        </td>
    
        <td>
            <?php if(in_array(get_station_id(), [$trip->from_id, $trip->from_id])): ?>
                <?php 
                $time = strtotime($trip->started_at);
                ?>
                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?> - <?php echo e(date('d/m/Y', $time)); ?></div>
            <?php else: ?>
                <?php 
                $time = strtotime($trip->arrived_at);
                ?>
                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?> - <?php echo e(date('d/m/Y', $time)); ?></div>
            <?php endif; ?>
                
            
        </td>
    </tr>

    <tr>
        <td>
            <?php if($st): ?>
                Đến nơi
            <?php else: ?>
                Xuất bến
            <?php endif; ?>
        </td>
    
        <td>
            <?php if(in_array(get_station_id(), [$trip->from_id, $trip->from_id])): ?>
                <?php 
                $time = strtotime($trip->arrived_at);
                ?>
                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?> - <?php echo e(date('d/m/Y', $time)); ?></div>
            <?php else: ?>
                <?php 
                $time = strtotime($trip->started_at);
                ?>
                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?> - <?php echo e(date('d/m/Y', $time)); ?></div>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Giá vé</td>
        <td>
            <?php if(!$trip->ticket_price): ?>
                Dang cập nhật
            <?php else: ?>
                <?php echo e(number_format($trip->ticket_price, 0, ',', '.')); ?> VNĐ
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td>Liên hệ</td>
        <td>
            <?php if($trip->company_phone_numeber): ?>
                <a href="tel:<?php echo e($trip->company_phone_numeber); ?>">
                    <?php echo e($trip->company_phone_numeber); ?>

                </a>
            <?php endif; ?>
        </td>
    </tr>

    
</tbody>
</table>
<?php endif; ?>
