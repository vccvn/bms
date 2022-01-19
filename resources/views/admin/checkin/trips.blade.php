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
                @if ($type==1)
                    <th>Số khách</th>
                @endif
                <th>
                    #
                </th>    
                
            </tr>
        </thead>
        <tbody>
            @if (count($trips))
                @foreach ($trips as $item)
                    <tr id="trip-log-{{$item->id}}">
                        <td>{{$item->id}}</td>
                        <td>{{$item->license_plate}}</td>
                        <td>
                            @if ($item->direction==1)
                                {{$item->from_station}}
                                <i class="fa fa-long-arrow-right"></i>
                                {{$item->to_station}}
                            @else
                                {{$item->to_station}}
                                <i class="fa fa-long-arrow-right"></i>
                                {{$item->from_station}}
                            @endif
                        </td>
                        <td>
                            @if ($type==1)
                                Xuất bến
                            @elseif($type==2)
                                Vào bến
                            @elseif($type==3)
                                Ghé bến (ra)
                            @else
                                Ghé bến (vào)
                            @endif
                        </td>
                        <td>
                            {{$item->hour}}h{{$item->minute}}
                            <br>
                            {{$item->day}}/{{$item->month}}/{{$item->year}}
                        </td>
                        @if ($type==1)
                            <td class="trip-tickets">
                                <input type="number" name="trip[{{$loop->index}}][tickets]" id="trip-tickets-{{$item->id}}" class="form-control" value="{{$item->tickets?$item->tickets:0}}">
                            </td>
                        @endif
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
                                $color = 'warning';
                                $text = 'Đã vào';
                                $status = 1;
                            }
                            ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-{{$color}} {{$className}} text-white btn-change-status" data-id="{{$item->id}}" data-status="{{$status}}" data-color="{{$color}}" data-type="{{$type}}">{{$text}}</a>

                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-cancel" data-id="{{$item->id}}">Hủy</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>