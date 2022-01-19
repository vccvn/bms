<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
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

                    <?php if(count($list)): ?>
                    <?php
                    $first = $list[0];
                    $r = $first->schedule->route;
                    $st = ($r->type == 'direct' || ($r->type=='bus' && in_array($__setting->station_id, [$r->from_id, $r->to_id])));
                    ?>

<style>

    
@media (max-width: 768px) {
  .result-data td:nth-of-type(1):before {
    content: "#";
  }
  .result-data td:nth-of-type(2):before {
    content: "Nhà xe";
  }
  .result-data td:nth-of-type(3):before {
    content: "Tuyến";
  }
  .result-data td:nth-of-type(4):before {
    content: "Lộ trình";
  }
  .result-data td:nth-of-type(5):before {
    content: "<?php echo e($trip_time_types[$first->route_type]); ?>";
  }
  .result-data td:nth-of-type(6):before {
    content: "<?php echo e($st?'Đến nơi':'Xuất bến'); ?>";
  }
  .result-data td:nth-of-type(7):before {
    content: "Giá vé";
  }
  .result-data td:nth-of-type(8):before {
    content: "Liên hệ";
  }
}

</style>
                        <div class="about-us responsive-table">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhà xe</th>
                                        <th>tuyến xe</th>
                                        <th>Lộ trình</th>
                                        <th>
                                            <?php echo e($trip_time_types[$first->route_type]); ?>

                                        </th>
                                        <th>
                                            <?php if($st): ?>
                                                Đến nơi
                                            <?php else: ?>
                                                Xuất bến
                                            <?php endif; ?>
                                        </th>
                                        <th>Giá vé</th>
                                        <th>Liên hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $route = $item->schedule->route;
                                    ?>


                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->company_name); ?></td>
                                        
                                        <td>
                                            <?php if($item->direction == 2): ?>
                                                <?php echo e($item->to_station); ?>

                                                -
                                                <?php echo e($item->from_station); ?>

                                                
                                            <?php else: ?>
                                                <?php echo e($item->from_station); ?>

                                                -
                                                <?php echo e($item->to_station); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            
                                            <a href="javascript:void(0);" class="btn-view-journey" data-id="<?php echo e($item->id); ?>">Xem chi tiết</a>
                                        </td>
                                        <td>
                                            <?php if(in_array(get_station_id(), [$item->from_id, $item->from_id])): ?>
                                                <?php 
                                                $time = strtotime($item->started_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y', $time)); ?></div>
                                            <?php else: ?>
                                                <?php 
                                                $time = strtotime($item->arrived_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y', $time)); ?></div>
                                            <?php endif; ?>
                                                
                                            
                                        </td>
                                        <td>
                                            <?php if(in_array(get_station_id(), [$item->from_id, $item->from_id])): ?>
                                                <?php 
                                                $time = strtotime($item->arrived_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y', $time)); ?></div>
                                            <?php else: ?>
                                                <?php 
                                                $time = strtotime($item->started_at);
                                                ?>
                                                <div><?php echo e(date('H', $time)); ?>h<?php echo e(date('i', $time)); ?></div>
                                                <div><?php echo e(date('d/m/Y', $time)); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!$item->ticket_price): ?>
                                                Dang cập nhật
                                            <?php else: ?>
                                                <?php echo e(number_format($item->ticket_price, 0, ',', '.')); ?> VNĐ
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
                    