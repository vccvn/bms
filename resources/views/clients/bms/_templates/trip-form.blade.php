<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
?>
    <div class="container-fluid trip-search-form" style="bottom: 0px">
        <div class="container header-filter bg-filter" >
            <div class="main-filter pt-3">
                <h3 class="pb-2">
                    <span class="text-bold text-white pl-3">Tìm chuyến</span>
                </h3>
                <form action="{{route('client.trip.search')}}" method="GET" id="trip-search-form">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group d-unset">
                                <label for="to" class="text-white">Điểm đi</label>
                                {!! 
                                    (new Input([
                                        'type' => 'cubeselect',
                                        'name' => 'from',
                                        'id'   => 'from-id',
                                        'data' => StationRepository::getStationOptions(),
                                        'default' => $from
                                    ]))
                                !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6  col-sm-6 col-12">
                            <div class="form-group d-unset">
                                <label for="from" class="text-white">Điểm đến</label>
                                {!! 
                                    (new Input([
                                        'type' => 'cubeselect',
                                        'name' => 'to',
                                        'id'   => 'to-id',
                                        'data' => StationRepository::getStationOptions(),
                                        'default' => $to
                                    ]))
                                !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6  col-sm-6 col-12">
                            <div class="form-group d-unset">
                                <label for="from" class="text-white">Ngày đi</label>
                                <div class="input-group bms-datetime-picker" data-format="DD/MM/YYYY">
                                    <input class="form-control datepicker" name="date" value="{{"$day/$month/$year"}}" />
                                    <div class="input-group-append input-group-addon">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center align-items-end d-gird">
                            <div class="form-group d-unset mb-0">
                                <button type="submit" class="btn">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    