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

                    @if (count($list))
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
    content: "{{$trip_time_types[$first->route_type]}}";
  }
  .result-data td:nth-of-type(6):before {
    content: "{{$st?'Đến nơi':'Xuất bến'}}";
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
                                            {{$trip_time_types[$first->route_type]}}
                                        </th>
                                        <th>
                                            @if ($st)
                                                Đến nơi
                                            @else
                                                Xuất bến
                                            @endif
                                        </th>
                                        <th>Giá vé</th>
                                        <th>Liên hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                    <?php
                                    $route = $item->schedule->route;
                                    ?>


                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->company_name}}</td>
                                        
                                        <td>
                                            @if ($item->direction == 2)
                                                {{$item->to_station}}
                                                -
                                                {{$item->from_station}}
                                                
                                            @else
                                                {{$item->from_station}}
                                                -
                                                {{$item->to_station}}
                                            @endif
                                        </td>
                                        <td>
                                            
                                            <a href="javascript:void(0);" class="btn-view-journey" data-id="{{$item->id}}">Xem chi tiết</a>
                                        </td>
                                        <td>
                                            @if (in_array(get_station_id(), [$item->from_id, $item->from_id]))
                                                <?php 
                                                $time = strtotime($item->started_at);
                                                ?>
                                                <div>{{date('H', $time)}}h{{date('i', $time)}}</div>
                                                <div>{{date('d/m/Y', $time)}}</div>
                                            @else
                                                <?php 
                                                $time = strtotime($item->arrived_at);
                                                ?>
                                                <div>{{date('H', $time)}}h{{date('i', $time)}}</div>
                                                <div>{{date('d/m/Y', $time)}}</div>
                                            @endif
                                                
                                            
                                        </td>
                                        <td>
                                            @if (in_array(get_station_id(), [$item->from_id, $item->from_id]))
                                                <?php 
                                                $time = strtotime($item->arrived_at);
                                                ?>
                                                <div>{{date('H', $time)}}h{{date('i', $time)}}</div>
                                                <div>{{date('d/m/Y', $time)}}</div>
                                            @else
                                                <?php 
                                                $time = strtotime($item->started_at);
                                                ?>
                                                <div>{{date('H', $time)}}h{{date('i', $time)}}</div>
                                                <div>{{date('d/m/Y', $time)}}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$item->ticket_price)
                                                Dang cập nhật
                                            @else
                                                {{number_format($item->ticket_price, 0, ',', '.')}} VNĐ
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->company_phone_numeber)
                                                <a href="tel:{{$item->company_phone_numeber}}">
                                                    {{$item->company_phone_numeber}}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                
                            </table>    
                        </div>
                        

                    @elseif(!$to)
                    <div class="alert alert-info text-center">
                        Hãy chọn điểm đến để tìm chuyến phù hợp với tài chính và thời gian của bạn!
                    </div>
                    @else
                        <div class="alert alert-warning text-center">
                            Không có chuyến nào
                        </div>
                    @endif
                    