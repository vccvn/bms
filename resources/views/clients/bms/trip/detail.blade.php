@if ($trip)
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
        <td>{{$trip->license_plate}}</td>
    </tr>

    <tr>
        <td>Nhà xe</td>
        <td>{{$trip->company_name}}</td>
    </tr>

    <tr>
        <td>Hướng đi</td>    
        <td>
            @if ($trip->direction == 2)
                {{$trip->to_station}}
                -
                {{$trip->from_station}}
                
            @else
                {{$trip->from_station}}
                -
                {{$trip->to_station}}
            @endif
        </td>
    </tr>

    <tr>
        <td>Lộ trình</td>
        <td>
            
            @if ($trip->direction == 2)
                Bến xe {{$trip->to_station}} - 
                @if ($route->reversePlace)
                    @foreach ($route->reversePlaces as $pl)
                        {{$pl->place_name}} - 
                    @endforeach
                @endif

                Bến xe {{$trip->from_station}}
                
            @else
                Bến xe {{$trip->from_station}} - 
                @if ($route->places)
                    @foreach ($route->places as $pl)
                        {{$pl->place_name}} - 
                    @endforeach
                @endif

                Bến xe {{$trip->to_station}}
            @endif
        </td>
    </tr>

    <tr>
        <td>
            {{$trip_time_types[$trip->route_type]}}
        </td>
    
        <td>
            @if (in_array(get_station_id(), [$trip->from_id, $trip->from_id]))
                <?php 
                $time = strtotime($trip->started_at);
                ?>
                <div>{{date('H', $time)}}h{{date('i', $time)}} - {{date('d/m/Y', $time)}}</div>
            @else
                <?php 
                $time = strtotime($trip->arrived_at);
                ?>
                <div>{{date('H', $time)}}h{{date('i', $time)}} - {{date('d/m/Y', $time)}}</div>
            @endif
                
            
        </td>
    </tr>

    <tr>
        <td>
            @if ($st)
                Đến nơi
            @else
                Xuất bến
            @endif
        </td>
    
        <td>
            @if (in_array(get_station_id(), [$trip->from_id, $trip->from_id]))
                <?php 
                $time = strtotime($trip->arrived_at);
                ?>
                <div>{{date('H', $time)}}h{{date('i', $time)}} - {{date('d/m/Y', $time)}}</div>
            @else
                <?php 
                $time = strtotime($trip->started_at);
                ?>
                <div>{{date('H', $time)}}h{{date('i', $time)}} - {{date('d/m/Y', $time)}}</div>
            @endif
        </td>
    </tr>

    <tr>
        <td>Giá vé</td>
        <td>
            @if (!$trip->ticket_price)
                Dang cập nhật
            @else
                {{number_format($trip->ticket_price, 0, ',', '.')}} VNĐ
            @endif
        </td>
    </tr>

    <tr>
        <td>Liên hệ</td>
        <td>
            @if ($trip->company_phone_numeber)
                <a href="tel:{{$trip->company_phone_numeber}}">
                    {{$trip->company_phone_numeber}}
                </a>
            @endif
        </td>
    </tr>

    
</tbody>
</table>
@endif
