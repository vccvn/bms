<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
?>
    <div class="container-fluid trip-search-form" style="bottom: 0px">
        <div class="container header-filter " >
            <div class="bg-filter" >
                <div class="main-filter p-4">
                    <h3 class="pb-2">
                        <span class="text-bold text-white pl-3">Tìm vé xe</span>
                    </h3>
                    <form action="<?php echo e(route('client.schedule.check')); ?>" method="GET">
                        <div class="col-md-12 row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                <div class="form-group d-unset">
                                    <label for="to" class="text-white">Điểm đi</label>
                                    <?php echo (new Input([
                                            'type' => 'cubeselect',
                                            'name' => 'from_id',
                                            'id'   => 'from_id',
                                            'data' => StationRepository::getStationOptions()
                                        ])); ?>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6  col-sm-6 col-6"">
                                <div class="form-group d-unset">
                                    <label for="from" class="text-white">Điểm đến</label>
                                    <?php echo (new Input([
                                            'type' => 'cubeselect',
                                            'name' => 'to_id',
                                            'id'   => 'to_id',
                                            'data' => StationRepository::getStationOptions()
                                        ])); ?>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6  col-sm-6 col-6">
                                <div class="form-group d-unset">
                                    <label for="from" class="text-white">Ngày đi</label>
                                    <div class="input-group bms-datetime-picker" data-format="DD/MM/YYYY">
                                        <input class="form-control datepicker" value="<?php echo e(date('d/m/Y')); ?>" />
                                        <div class="input-group-append input-group-addon">
                                            <div class="input-group-text">
                                                <i class="fa fa-calculator"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center align-items-end d-gird">
                                <div class="form-group d-unset mb-0">
                                    <button type="submit" class="btn">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    