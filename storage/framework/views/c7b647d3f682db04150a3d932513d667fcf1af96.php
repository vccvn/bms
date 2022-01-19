<?php
use Cube\Any;
?>
<div class="card">
    <div class="card card-block sameheight-item">
        <div class="title-block">
            <h3 class="title"> Hướng đi: 
                <?php echo e($route->toStation->name); ?> 
                <i class="fa fa-long-arrow-right"></i> 
                <?php echo e($route->fromStation->name); ?> 
                
            </h3>
        </div>
        <section class="break-point">
            <div class="table-responsive">
                <table class="table table-bordered date-table go-in">
                    <thead>
                        <tr>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th>
                                <?php echo e($day); ?>

                            </th>    
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($calendar) && $calendar): ?>
                            <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if($week): ?>
                                        <?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php 
                                            $d = new Any($day); 
                                            $t = $d->type == 'day';
                                            $disable = in_array($d->day, $days_available)?false:true;
                                            ?>
                                            <td class="<?php echo e($t?'day-block':''); ?> <?php echo e(($disable || !$t)? ' disabled':'day-available'); ?>">
                                                <?php if($t): ?>
                                                    <div class="day-group">
                                                        <label class="item-check d-block day-check-block">
                                                            <input type="checkbox" 
                                                            name="back_date[]" 
                                                            class="check-item checkbox day-check day-<?php echo e($d->day); ?>" 
                                                            value="<?php echo e($d->date); ?>" data-day="<?php echo e($d->day); ?>" <?php echo e($disable? 'disabled':''); ?>  <?php echo e((($disable && in_array($d->date, $backs)) || in_array($d->date,$go_back))? 'checked':''); ?>>
                                                            <span></span>
                                                            
                                                        </label>
                                                        
                                                    </div>
                                                    <span class="day-text"><?php echo e($d->day); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($errors->has('back_date')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo e($errors->first('back_date')); ?>

                </div>
            <?php endif; ?>
        </section>
        <div class="check-all <?php echo e(!$days_available? 'disabled':''); ?>">
            <label class="item-check d-block">
                <input type="checkbox" name="check-_all_in_date" class="check-item checkbox" <?php echo e(!$days_available? 'disabled':''); ?>>
                <span></span>
                <span>Chọn tất cả</span>
            </label>
            
        </div>
        <?php for($i = 0; $i < $freq_trips; $i++): ?>
            <?php
                $old_started = null;
                $old_arrived = null;
                $et_time = null;
                $et_day = null;
                $et_hour = null;
                $et_minute =null;
                $et_second = null;
                
                $st_hour = null;
                $st_minute =null;
                $st_second = null;
                
                $ar_hour = null;
                $ar_minute =null;
                $ar_second = null;
                if(isset($back_trips) && $back_trips){
                    if(isset($back_trips[$i]) && $back_trips[$i]){
                        $trip = $back_trips[$i];

                        $old_started = isset($trip['old_started'])?$trip['old_started']:null;
                        $old_arrived = isset($trip['old_arrived'])?$trip['old_arrived']:null;
                        $et_time = isset($trip['estimated_time'])?$trip['estimated_time']:null;

                        $et_array = isset($trip['estimated_time_array'])?$trip['estimated_time_array']:[];
                        $et_day = isset($et_array['day'])?$et_array['day']:null;
                        $et_hour = isset($et_array['hour'])?$et_array['hour']:null;
                        $et_minute = isset($et_array['minute'])?$et_array['minute']:null;
                        $et_second = isset($et_array['second'])?$et_array['second']:null;

                        $st_array = isset($trip['started'])?$trip['started']:[];
                        $st_hour = isset($st_array['hour'])?$st_array['hour']:null;
                        $st_minute = isset($st_array['minute'])?$st_array['minute']:null;
                        $st_second = isset($st_array['second'])?$st_array['second']:null;

                        $ar_array = isset($trip['arrived'])?$trip['arrived']:[];
                        $ar_hour = isset($ar_array['hour'])?$ar_array['hour']:null;
                        $ar_minute = isset($ar_array['minute'])?$ar_array['minute']:null;
                        $ar_second = isset($ar_array['second'])?$ar_array['second']:null;
                    }
                }
                $old_st_hour = old('back_trips.'.$i.'.st_hour', $st_hour);
                $old_st_minute = old('back_trips.'.$i.'.st_minute', $st_minute);
                $old_ar_hour = old('back_trips.'.$i.'.ar_hour', $ar_hour);
                $old_ar_minute = old('back_trips.'.$i.'.ar_minute', $ar_minute);
                
                $old_et_day = old('back_trips.'.$i.'.et_day', $et_day);
                $old_et_hour = old('back_trips.'.$i.'.et_hour', $et_hour);
                $old_et_minute = old('back_trips.'.$i.'.et_minute', $et_minute);


                $st_time_error = ($errors->has('back_trips.'.$i.'.st_hour') || $errors->has('back_trips.'.$i.'.st_minute') || session('time_arrive'));
                $et_time_error = ($errors->has('back_trips.'.$i.'.et_hour') || $errors->has('back_trips.'.$i.'.et_minute'));
                $ar_time_error = ($errors->has('back_trips.'.$i.'.ar_hour') || $errors->has('back_trips.'.$i.'.ar_minute'));

                ?>
<div class="mb-3">
<?php if($freq_trips>1): ?>
<div class="title-block">
    <h4 class="title">Chuyến <?php echo e($i+1); ?></h4>
</div>
<?php endif; ?>
<?php if($route->type == 'direct' || ($route->type=='bus' && in_array(get_station_id(), [$route->from_id, $route->to_id]))): ?>
    <div class="form-group row <?php echo e($st_time_error?'has-error':''); ?>" id="form-group-back_trips-<?php echo e($i); ?>-started">
        <label for="back_trips-<?php echo e($i); ?>-started" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-back_trips<?php echo e($i); ?>-started">Xuất bến</label>
        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
            <input type="hidden" name="back_trips[<?php echo e($i); ?>][old_started]" value="<?php echo e($old_started); ?>">
            
            <div class="row">
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][st_hour]" class="form-control">
                        <option value="">Giờ</option>
                        <?php for($j = 0; $j < 24; $j++): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_st_hour) && $j == $old_st_hour? 'selected':''); ?>><?php echo e($j.' giờ'); ?> </option>
                        <?php endfor; ?>
                    </select>
                    
                </div>
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][st_minute]" class="form-control">
                        <option value="">Phút</option>
                        <?php for($j = 0; $j < 60; $j+=5): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_st_minute) && $j == $old_st_minute ? 'selected':''); ?>>
                                <?php echo e($j.' phut'); ?>

                                </option>
                        <?php endfor; ?>
                    </select>
                    
                </div>
                
            </div>
            <div class="errors">
                <?php if($st_time_error): ?>
                    <span class="has-error">
                        <?php echo e(session('time_arrive')?session('time_arrive'):"Thời gian xuất phát không hợp lệ"); ?>

                    </span>
                <?php endif; ?>
            </div>
            
        </div>
    </div>

    <div class="form-group row <?php echo e($et_time_error?'has-error':''); ?>" id="form-group-back_trips-<?php echo e($i); ?>-arrived">
        <label for="back_trips-<?php echo e($i); ?>-arrived_at" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-back_trips<?php echo e($i); ?>-started_at">Đến nơi sau...</label>
        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
            <input type="hidden" name="back_trips[<?php echo e($i); ?>][et_time]" value="<?php echo e($et_time); ?>">
            
            <div class="row">
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][et_day]" class="form-control">
                        <?php for($j = 0; $j < 31; $j++): ?>
                            <option value="<?php echo e($j); ?>" <?php echo e(!is_null($old_et_day) && $j == $old_et_day ? 'selected':''); ?>><?php echo e($j>0?$j.' ngày':'Ngày'); ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][et_hour]" class="form-control">
                        <option value="">Giờ</option>
                        <?php for($j = 0; $j < 24; $j++): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_et_hour) && $j == $old_et_hour ? 'selected':''); ?>><?php echo e($j.' giờ'); ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][et_minute]" class="form-control">
                        <option value="">Phút</option>
                        <?php for($j = 0; $j < 60; $j+=5): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_et_minute) && $j == $old_et_minute ? 'selected':''); ?>>
                                <?php echo e($j.' phut'); ?>

                                </option>
                        <?php endfor; ?>
                    </select>
            
                </div>
                
            </div>
            <div class="errors">
                <?php if($et_time_error): ?>
                    <span class="has-error">
                        Thời gian dự kiến không hợp lệ
                    </span>
                <?php endif; ?>
                
            </div>
            

        </div>
    </div>
        
<?php else: ?>

    <div class="form-group row <?php echo e($ar_time_error?'has-error':''); ?>" id="form-group-back_trips-<?php echo e($i); ?>-started">
        <label for="back_trips-<?php echo e($i); ?>-arrived" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-back_trips<?php echo e($i); ?>-started">Vào bến</label>
        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
            <input type="hidden" name="back_trips[<?php echo e($i); ?>][old_arrived]" value="<?php echo e($old_arrived); ?>">
            
            <div class="row">
                <div class="col-4 auto">
                    <select name="back_trips[<?php echo e($i); ?>][ar_hour]" class="form-control">
                        <option value="">Giờ</option>
                        <?php for($j = 0; $j < 24; $j++): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_ar_hour) && $j == $old_ar_hour ? 'selected':''); ?>><?php echo e($j.' giờ'); ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][ar_minute]" class="form-control">
                        <option value="">Phút</option>
                        <?php for($j = 0; $j < 60; $j+=5): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_ar_minute) && $j == $old_ar_minute ? 'selected':''); ?>>
                                <?php echo e($j.' phut'); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
            </div>
            <div class="errors">
                <?php if($ar_time_error): ?>
                    <span class="has-error">
                        Thời gian vào bến không hợp lệ
                    </span>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    

    <div class="form-group row <?php echo e($st_time_error?'has-error':''); ?>" id="form-group-back_trips-<?php echo e($i); ?>-started">
        <label for="back_trips-<?php echo e($i); ?>-started" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-back_trips<?php echo e($i); ?>-started">Xuất bến</label>
        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
            <input type="hidden" name="back_trips[<?php echo e($i); ?>][old_started]" value="<?php echo e($old_started); ?>">
            
            <div class="row">
                <div class="col-4 auto">
                    <select name="back_trips[<?php echo e($i); ?>][st_hour]" class="form-control">
                        <option value="">Giờ</option>
                        <?php for($j = 0; $j < 24; $j++): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_st_hour) && $j == $old_st_hour ? 'selected':''); ?>><?php echo e($j.' giờ'); ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-4">
                    <select name="back_trips[<?php echo e($i); ?>][st_minute]" class="form-control">
                        <option value="">Phút</option>
                        <?php for($j = 0; $j < 60; $j+=5): ?>
                            <option value="<?php echo e(str_pad($j, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e(!is_null($old_st_minute) && $j == $old_st_minute ? 'selected':''); ?>>
                                <?php echo e($j.' phut'); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
            </div>
            <div class="errors">
                <?php if($st_time_error): ?>
                    <span class="has-error">
                        Thời gian xuất bến không hợp lệ!
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
        
<?php endif; ?>


</div>
<?php endfor; ?>

</div>
</div>