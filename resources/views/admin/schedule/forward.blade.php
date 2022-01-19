<?php
 use Cube\Any;
 ?>
 <div class="card">
    <div class="card card-block sameheight-item">
        <div class="title-block">
            <h3 class="title"> Hướng đi: 
                {{$route->fromStation->name}} 
                <i class="fa fa-long-arrow-right"></i> 
                {{$route->toStation->name}} 
            </h3>
        </div>
        <section class="break-point">
            <div class="table-responsive">
                <table class="table table-bordered date-table go-out">
                    <thead>
                        <tr>
                            @foreach ($days as $day)
                            <th>
                                {{$day}}
                            </th>    
                            @endforeach
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($calendar) && $calendar)
                            @foreach ($calendar as $week)
                                <tr>
                                    @if ($week)
                                        @foreach ($week as $day)
                                            <?php 
                                            $d = new Any($day); 
                                            $t = $d->type == 'day';
                                            $disable = in_array($d->day, $days_available)?false:true;
                                            ?>
                                            <td class="{{$t?'day-block':''}} {{($disable || !$t)? ' disabled':'day-available'}}">
                                                @if ($t)
                                                    <div class="day-group">
                                                        <label class="item-check d-block day-check-block">
                                                            <input type="checkbox" 
                                                            name="forward_date[]" 
                                                            class="check-item checkbox day-check day-{{$d->day}}" 
                                                            value="{{$d->date}}" data-day="{{$d->day}}" {{$disable? 'disabled':''}}  {{
                                                            (($disable && in_array($d->date, $forwards)) || in_array($d->date,$go_forward))? 'checked':''
                                                            }}>
                                                            <span></span>
                                                            
                                                        </label>
                                                        
                                                    </div>
                                                    <span class="day-text">{{$d->day}}</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($errors->has('forward_date'))
                <div class="alert alert-danger text-center">
                    {{$errors->first('forward_date')}}
                </div>
            @endif
        </section>
        <div class="check-all {{!$days_available? 'disabled':''}}">
            <label class="item-check d-block">
                <input type="checkbox" name="check-_all_out_date" class="check-item checkbox" {{!$days_available? 'disabled':''}}>
                <span></span>
                <span>Chọn tất cả</span>
            </label>
            
        </div>
        @for ($i = 0; $i < $freq_trips; $i++)
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
                if(isset($forward_trips) && $forward_trips){
                    if(isset($forward_trips[$i]) && $forward_trips[$i]){
                        $trip = $forward_trips[$i];

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
                $old_st_hour = old('forward_trips.'.$i.'.st_hour', $st_hour);
                $old_st_minute = old('forward_trips.'.$i.'.st_minute', $st_minute);
                $old_ar_hour = old('forward_trips.'.$i.'.ar_hour', $ar_hour);
                $old_ar_minute = old('forward_trips.'.$i.'.ar_minute', $ar_minute);
                
                $old_et_day = old('forward_trips.'.$i.'.et_day', $et_day);
                $old_et_hour = old('forward_trips.'.$i.'.et_hour', $et_hour);
                $old_et_minute = old('forward_trips.'.$i.'.et_minute', $et_minute);


                $st_time_error = ($errors->has('forward_trips.'.$i.'.st_hour') || $errors->has('forward_trips.'.$i.'.st_minute') || session('time_start'));
                $et_time_error = ($errors->has('forward_trips.'.$i.'.et_hour') || $errors->has('forward_trips.'.$i.'.et_minute'));
                $ar_time_error = ($errors->has('forward_trips.'.$i.'.ar_hour') || $errors->has('forward_trips.'.$i.'.ar_minute'));
                
            ?>
            <div class="mb-3">
                @if ($freq_trips>1)
                <div class="title-block">
                    <h4 class="title">Chuyến {{$i+1}}</h4>
                </div>
                @endif
                @if ($route->type == 'direct' || ($route->type=='bus' && in_array(get_station_id(), [$route->from_id, $route->to_id])))
                    <div class="form-group row {{$st_time_error?'has-error':''}}" id="form-group-forward_trips-{{$i}}-started">
                        <label for="forward_trips-{{$i}}-started" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-forward_trips{{$i}}-started">Xuất bến</label>
                        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
                            <input type="hidden" name="forward_trips[{{$i}}][old_started]" value="{{$old_started}}">
                            
                            <div class="row">
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][st_hour]" class="form-control">
                                        <option value="">Giờ</option>
                                        @for ($j = 0; $j < 24; $j++)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_st_hour) && $j == $old_st_hour? 'selected':''}}>{{$j.' giờ'}} </option>
                                        @endfor
                                    </select>
                                    
                                </div>
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][st_minute]" class="form-control">
                                        <option value="">Phút</option>
                                        @for ($j = 0; $j < 60; $j+=5)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_st_minute) && $j == $old_st_minute ? 'selected':''}}>
                                                {{$j.' phut'}}
                                                </option>
                                        @endfor
                                    </select>
                                    
                                </div>
                                
                            </div>
                            <div class="errors">
                                @if ($st_time_error)
                                    <span class="has-error">
                                        {{session('time_start')?session('time_start'):"Thời gian xuất phát không hợp lệ"}}
                                    </span>
                                @endif
                            </div>
                            
                        </div>
                    </div>
    
                    <div class="form-group row {{$et_time_error?'has-error':''}}" id="form-group-forward_trips-{{$i}}-arrived">
                        <label for="forward_trips-{{$i}}-arrived_at" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-forward_trips{{$i}}-started_at">Đến nơi sau...</label>
                        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
                            <input type="hidden" name="forward_trips[{{$i}}][et_time]" value="{{$et_time}}">
                            
                            <div class="row">
                                <div class="col-4 ml-auto">
                                    <select name="forward_trips[{{$i}}][et_day]" class="form-control">
                                        @for ($j = 0; $j < 31; $j++)
                                            <option value="{{$j}}" {{!is_null($old_et_day) && $j == $old_et_day ? 'selected':''}}>{{$j>0?$j.' ngày':'Ngày'}} </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][et_hour]" class="form-control">
                                        <option value="">Giờ</option>
                                        @for ($j = 0; $j < 24; $j++)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_et_hour) && $j == $old_et_hour ? 'selected':''}}>{{$j.' giờ'}} </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][et_minute]" class="form-control">
                                        <option value="">Phút</option>
                                        @for ($j = 0; $j < 60; $j+=5)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_et_minute) && $j == $old_et_minute ? 'selected':''}}>
                                                {{$j.' phut'}}
                                                </option>
                                        @endfor
                                    </select>
                            
                                </div>
                                
                            </div>
                            <div class="errors">
                                @if ($et_time_error)
                                    <span class="has-error">
                                        Thời gian dự kiến không hợp lệ
                                    </span>
                                @endif
                                
                            </div>
                            

                        </div>
                    </div>
                        
                @else

                    <div class="form-group row {{$ar_time_error?'has-error':''}}" id="form-group-forward_trips-{{$i}}-started">
                        <label for="forward_trips-{{$i}}-arrived" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-forward_trips{{$i}}-started">Vào bến</label>
                        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
                            <input type="hidden" name="forward_trips[{{$i}}][old_arrived]" value="{{$old_arrived}}">
                            
                            <div class="row">
                                <div class="col-4 auto">
                                    <select name="forward_trips[{{$i}}][ar_hour]" class="form-control">
                                        <option value="">Giờ</option>
                                        @for ($j = 0; $j < 24; $j++)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_ar_hour) && $j == $old_ar_hour ? 'selected':''}}>{{$j.' giờ'}} </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][ar_minute]" class="form-control">
                                        <option value="">Phút</option>
                                        @for ($j = 0; $j < 60; $j+=5)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_ar_minute) && $j == $old_ar_minute ? 'selected':''}}>
                                                {{$j.' phut'}}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                            </div>
                            <div class="errors">
                                @if ($ar_time_error)
                                    <span class="has-error">
                                        Thời gian vào bến không hợp lệ
                                    </span>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    

                    <div class="form-group row {{$st_time_error?'has-error':''}}" id="form-group-forward_trips-{{$i}}-started">
                        <label for="forward_trips-{{$i}}-started" class="form-control-label col-sm-4 col-md-12 col-lg-4 col-xl-3" id="label-for-forward_trips{{$i}}-started">Xuất bến</label>
                        <div class="input-datetime-wrapper col-sm-8 col-md-12 col-lg-8 col-xl-9">
                            <input type="hidden" name="forward_trips[{{$i}}][old_started]" value="{{$old_started}}">
                            
                            <div class="row">
                                <div class="col-4 auto">
                                    <select name="forward_trips[{{$i}}][st_hour]" class="form-control">
                                        <option value="">Giờ</option>
                                        @for ($j = 0; $j < 24; $j++)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_st_hour) && $j == $old_st_hour ? 'selected':''}}>{{$j.' giờ'}} </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="forward_trips[{{$i}}][st_minute]" class="form-control">
                                        <option value="">Phút</option>
                                        @for ($j = 0; $j < 60; $j+=5)
                                            <option value="{{str_pad($j, 2, '0', STR_PAD_LEFT)}}" {{!is_null($old_st_minute) && $j == $old_st_minute ? 'selected':''}}>
                                                {{$j.' phut'}}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                            </div>
                            <div class="errors">
                                @if ($st_time_error)
                                    <span class="has-error">
                                        Thời gian xuất bến không hợp lệ!
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                @endif

                
            </div>
        @endfor
            
    </div>
</div>