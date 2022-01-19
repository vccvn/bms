<?php
use App\Light\Any;
$trip = $model;

$after_year = date('Y')+10;

$status = ['100' => 'Đã hoàn thành', '0' => 'Chờ', '-1' => 'Bị hủy'];
$status2 = ['100' => 'Đã hoàn thành', '1' => 'Chờ xuất bến', '0' => 'Chờ', '-1' => 'Bị hủy'];

$is_direct = ($trip->route_type == 'direct' || ($trip->route_type=='bus' && in_array(get_station_id(), [$trip->from_id, $trip->to_id])));

$arr_status  = $is_direct ? $status : $status2;

?>
    <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $trip->id)}}" class="trip-input">
    <div class="form-group row">
        <label for="" class="form-control-label col-sm-3">Biển số</label>
        <div class="col-sm-9">{{$trip->license_plate}}</div>
    </div>
    <div class="form-group row">
        <label for="" class="form-control-label col-sm-3">Hướng đi</label>
        <div class="col-sm-9">
            @if ($trip->direction == 1)
                {{$trip->from_station}}
                <i class="fa fa-long-arrow-right"></i>

                {{$trip->to_station}}
                
            @else
                {{$trip->to_station}}
                <i class="fa fa-long-arrow-right"></i>

                {{$trip->from_station}}
                
            @endif
        </div>
    </div>
    
    @if ($is_direct)
        <div class="form-group row">
            <label for="" class="form-control-label col-sm-3">Loại chuyến</label>
            <div class="col-sm-9">Trực tiếp</div>
        </div>
        <div class="started-wrapper">
            <label for="started-day" class="form-control-label required" id="label-for-started-day">Xuất bến</label>
            <div class="input-date-wrapper">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="started-day">Ngày</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <select name="started[day]" id="started-day" class="trip-input form-control">
                                    <option value="">Ngày</option>
                                    @for ($i = 1; $i < 32; $i++)
                                        <option value="{{$d = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['day'] == $i?'selected':''}}>{{$d}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="started[month]" id="started-month" class="trip-input form-control">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['month'] == $i?'selected':''}}>Tháng {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="started[year]" id="started-year" class="trip-input form-control">
                                    <option value="">TNăm</option>
                                    @for ($i = 2017; $i < $after_year; $i++)
                                        <option value="{{$i}}" {{$trip->started['year'] == $i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="started-hour">Giờ</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <select name="started[hour]" id="started-hour" class="trip-input form-control">
                                            <option value="00">Giờ</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{$h = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['hour'] == $i?'selected':''}}>{{$i}}h</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="started[minute]" id="started-minute" class="trip-input form-control">
                                            <option value="00">Phut</option>
                                            @for ($i = 0; $i < 60; $i+=5)
                                                <option value="{{$m = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['minute'] == $i?'selected':''}}>{{$m}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="Wstimated-wrapper">
            
            <div class="input-date-wrapper">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="Wstimated-day" class="form-control-label required" id="label-for-Wstimated-day">Đến nơi...</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-addon bg-transparent border-0">
                                        <span class="input-group-text">+</span>
                                    </div>
                                    <select name="Wstimated[day]" id="Wstimated-day" class="trip-input form-control">
                                        <option value="">Ngày</option>
                                        @for ($i = 1; $i < 32; $i++)
                                            <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->estimated['day'] == $i?'selected':''}}>{{$i}} ngày</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <select name="Wstimated[hour]" id="Wstimated-hour" class="trip-input form-control">
                                            <option value="00">Giờ</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{$h = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->estimated['hour'] == $i?'selected':''}}>{{$i}}h</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="Wstimated[minute]" id="Wstimated-minute" class="trip-input form-control">
                                            <option value="00">Phut</option>
                                            @for ($i = 0; $i < 60; $i+=5)
                                                <option value="{{$m = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->estimated['minute'] == $i?'selected':''}}>{{$m}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="form-group row">
            <label for="" class="form-control-label col-sm-3">Loại chuyến</label>
            <div class="col-sm-9">Ghé bến</div>
        </div>
        <div class="arrived-wrapper">
            <label for="arrived-day" class="form-control-label required" id="label-for-arrived-day">Vào bến</label>
            <div class="input-date-wrapper">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="arrived-day">Ngày</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <select name="arrived[day]" id="arrived-day" class="trip-input form-control">
                                    <option value="">Ngày</option>
                                    @for ($i = 1; $i < 32; $i++)
                                        <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->arrived['day'] == $i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="arrived[month]" id="arrived-month" class="trip-input form-control">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->arrived['month'] == $i?'selected':''}}>Tháng {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="arrived[year]" id="arrived-year" class="trip-input form-control">
                                    <option value="">TNăm</option>
                                    @for ($i = 2017; $i < $after_year; $i++)
                                        <option value="{{$i}}" {{$trip->arrived['year'] == $i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="arrived-hour">Giờ</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <select name="arrived[hour]" id="arrived-hour" class="trip-input form-control">
                                            <option value="00">Giờ</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{$h = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->arrived['hour'] == $i?'selected':''}}>{{$i}}h</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="arrived[minute]" id="arrived-minute" class="trip-input form-control">
                                            <option value="00">Phut</option>
                                            @for ($i = 0; $i < 60; $i+=5)
                                                <option value="{{$m = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->arrived['minute'] == $i?'selected':''}}>{{$m}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="started-wrapper">
            <label for="started-day" class="form-control-label required" id="label-for-started-day">Xuất bến</label>
            <div class="input-date-wrapper">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="started-day">Ngày</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <select name="started[day]" id="started-day" class="trip-input form-control">
                                    <option value="">Ngày</option>
                                    @for ($i = 1; $i < 32; $i++)
                                        <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['day'] == $i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="started[month]" id="started-month" class="trip-input form-control">
                                    <option value="">Tháng</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['month'] == $i?'selected':''}}>Tháng {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <select name="started[year]" id="started-year" class="trip-input form-control">
                                    <option value="">TNăm</option>
                                    @for ($i = 2017; $i < $after_year; $i++)
                                        <option value="{{$i}}" {{$trip->started['year'] == $i?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="started-hour">Giờ</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto">
                                        <select name="started[hour]" id="started-hour" class="trip-input form-control">
                                            <option value="00">Giờ</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{$h = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['hour'] == $i?'selected':''}}>{{$i}}h</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="started[minute]" id="started-minute" class="trip-input form-control">
                                            <option value="00">Phut</option>
                                            @for ($i = 0; $i < 60; $i+=5)
                                                <option value="{{$m = str_pad($i, 2, '0', STR_PAD_LEFT)}}" {{$trip->started['minute'] == $i?'selected':''}}>{{$m}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @endif


    <div class="form-group row">
        <label for="update-trip-status" class="form-control-label col-sm-3">Trạng thái</label>
        <div class="col-sm-9">
            <select name="status" id="update-trip-status" class="form-control trip-input">
                @foreach ($arr_status as $value => $text)
                    <option value="{{$value}}" {{$value == $trip->status?'selected':''}}>{{$text}}</option>
                @endforeach
            </select>
        </div>
    </div>