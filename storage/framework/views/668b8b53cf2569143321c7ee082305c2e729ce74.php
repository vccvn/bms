<div class="table-responsive">
    <table class="table table-bordered date-table go-in">
        <thead>
            <tr>
                <th>
                    Mã chuyến
                </th>    
                <th>
                    Biển số
                </th>    
                <th>
                    Hướng đi
                </th>    
                <th>
                    Hình thức
                </th>    
                <th>
                    Thời gian
                </th>    
                <th>
                    #
                </th>    
                
            </tr>
        </thead>
        <tbody>
            <?php if(count($trips)): ?>
                <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="trip-log-<?php echo e($item->id); ?>">
                        <td><?php echo e($item->id); ?></td>
                        <td><?php echo e($item->license_plate); ?></td>
                        <td>
                            <?php if($item->direction==1): ?>
                                <?php echo e($item->from_station); ?>

                                <i class="fa fa-long-arrow-right"></i>
                                <?php echo e($item->to_station); ?>

                            <?php else: ?>
                                <?php echo e($item->to_station); ?>

                                <i class="fa fa-long-arrow-right"></i>
                                <?php echo e($item->from_station); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($type==1): ?>
                                Xuất bến
                            <?php elseif($type==2): ?>
                                Vào bến
                            <?php elseif($type==3): ?>
                                Ghé bến (ra)
                            <?php else: ?>
                                Ghé bến (vào)
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($item->hour); ?>h<?php echo e($item->minute); ?>

                            <br>
                            <?php echo e($item->day); ?>/<?php echo e($item->month); ?>/<?php echo e($item->year); ?>

                        </td>
                        <td>
                            <?php
                            $className = '';
                            $text = '';
                            $status = 100;
                            $color = '';
                            if ($type==1){
                                $className = 'btn-complete';
                                $color = 'primary';
                                $text = 'Hoàn thành';
                            }elseif($type==2){
                                $className = 'success btn-complete';
                                $color = 'success';
                                $text = 'Hoàn thành';
                            }elseif($type==3){
                                $className = 'primary btn-complete';
                                $color = 'primary';
                                $text = 'Hoàn thành';
                            }else{
                                $className = 'warning btn-prepare';
                                $color = 'danger';
                                $text = 'Đã vào';
                                $status = 1;
                            }
                            ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-<?php echo e($color); ?> <?php echo e($className); ?> btn-change-status" data-id="<?php echo e($item->id); ?>" data-status="<?php echo e($status); ?>" data-color="<?php echo e($color); ?>" data-type="<?php echo e($type); ?>"><?php echo e($text); ?></a>

                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-cancel" data-id="<?php echo e($item->id); ?>">Hủy</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>