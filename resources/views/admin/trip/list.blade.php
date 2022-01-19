<?php 
use Cube\Html\Input;

$title = 'Quản lý chuyến';



$status_texts = [
    '0' => 'Chờ',
    '1' => 'Chờ xuất bến',
    '100' => 'Hoàn thành',
    "-1" => 'Bị hủy',
    
];

$status_colors = [
    '0' => 'default',
    '1' => 'warning',
    '100' => 'success',
    "-1" => 'danger',
    
];


$types = ['direct' => 'Cố định','indirect' => 'Cố định', 'bus' => 'Buýt'];

$trip_time_types = [
    'direct' => [
        1 => 'Xuất bến (đi)',
        2 => 'Vào bến (về)'
    ],
    'indirect' => [
        1 => 'Ghé bến (đi)',
        2 => 'Ghé bến (về)'
    ],
    'bus' => [
        1 => 'Xuất bến',
        2 => 'Vào bến'
    ]
];

?>


@extends($__layouts.'main')

@section('title', $title)

@section('content')

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Quản lý chuyến
                    </h3>
                </div>

            </div>
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        @include('admin.trip.search-filter',[
            'search_filter'=>[
                'license_plate' => 'Biển số',
                'route_name' => 'Tên tuyến',
            ]
        ])
        @if($list->count()>0)
        <ul class="item-list striped list-body list-item">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Mã chuyến</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header item-col-same-sm item-col-title">
                        <div>
                            <span>Biển số</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Tuyến</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Hướng đi</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Phân loại</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Thời gian</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Trạng thái</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header fixed item-col-stats item-col-same-sm"> 
                        <div class="text-center">
                            <span>Hành động</span>
                        </div>
                    </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="comments[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Mã chuyến</div>
                        <div class="no-overflow">
                            <span>{{$item->id}}</span>
                        </div>
                    </div>
                    
                    <div class="item-col fixed pull-left item-col-title item-col-same-sm">
                        <div class="item-heading">Biển kiểm soát</div>
                        <div>
                            <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->license_plate}}"> 
                                <a href="{{$url = route('admin.schedule.detail',['year'=>$item->year, 'month'=>$item->month, 'license_plate'=>$item->license_clean])}}" class="">{{$item->license_plate}} </a>
                            </h4>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Tuyến</div>
                        <div class="no-overflow">
                            <span>{{$types[$item->route_type]}}</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Hướng đi</div>
                        <div class="no-overflow">
                            <span>
                                @if ($item->direction == 2)
                                    {{$item->to_station}} <i class="fa fa-long-arrow-right"></i> {{$item->from_station}}
                                @else
                                    {{$item->from_station}} <i class="fa fa-long-arrow-right"></i> {{$item->to_station}}
                                @endif
                            </span>
                        </div>
                    </div>
                   
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Phân loại</div>
                        <div class="no-overflow">
                            <span>{{$trip_time_types[$item->route_type][$item->direction]}}</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-md item-col-stats">
                        <div class="item-heading">Thời gian</div>
                        <div class="time">
                            <div>{{$item->hour}}h{{$item->minute}}</div>
                            <div>{{$item->day}}/{{$item->month}}/{{$item->year}}</div>
                        </div>
                    </div>
                
                    <div class="item-col item-col-stats item-col-same-sm">
                        <div class="item-heading">Trạng thái</div>
                        <div class="">
                            <div class="btn-group trip-status-select select-dropdown">
                                <button type="button" class="btn btn-secondary text-{{$status_colors[$item->status]}} btn-sm dropdown-toggle status-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$status_texts[$item->status]}}
                                </button>
                                <div class="dropdown-menu status-select select-dropdown-menu">
                                    @forelse($status_texts as $st => $t)
                                    <a data-id="{{$item->id}}" 
                                        data-status="{{$st}}" 
                                        id="trip-item-{{$item->id}}-{{$st}}" 
                                        href="#" 
                                        title="chuyển sang {{$t}}" 
                                        class="dropdown-item nav-link pt-1 pb-1 {{$st==$item->status?'active':''}}"> {{$t}} </a>
                                    @empty

                                    @endforelse
                                </div>    
                            </div>
                        </div>
                    </div>
                        
                    
                    <div class="item-col fixed item-col-stats pull-right item-col-same-sm">
                        <div class="item-actions">
                            <ul class="actions-list">
                                <li>
                                    <a href="#" class="edit btn-update-item" data-id="{{$item->id}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}" data-month="{{$item->month}}" data-year="{{$item->year}}" title="xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-4">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-8">
                    <nav aria-label="Page navigation example" class="text-right">
                        {{$list->links('vendor.pagination.custom')}}
                    </nav>
                </div>
            </div>
        </div>
        @else
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
        @endif
        
    </div>

</article>

@endsection

@section('jsinit')

<?php 
    $templates = [
        'form' => '
            <div id="update-item-form">
                {$form}
            </div>
        ',
        'message' => '
            <div id="update-item-message" class="d-none">
                <div class="alert alert-success message" id="update-item-message-text">{$message}</div>
            </div>
        ',
        'loading' => '
            <div id="forn-animate-loading" class="loader-block d-none">
                <div class="lds-ripple"><div></div><div></div></div>
            </div>
        ',
        'buttons' => [
            ['type'=>'button', 'className'=>'btn btn-primary btn-submit-update', 'text' =>'Cập nhật'],
            ['type'=>'button', 'className'=>'btn btn-primary btn-back-to-form d-none', 'text' =>'<i class="fa fa-arrow-left"></i> Quay lại']
        ]
    ];
?>


<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.trip.delete')}}'
            }
        });
    };
    window.tripsInit = function() {
        Cube.trips.init({
            urls:{
                change_status_url:  '{{route('admin.trip.status')}}',
                get_form_url:  '{{route('admin.trip.get-form')}}',
                save_url: '{{route('admin.trip.save')}}',
            },
            templates: {!! json_encode($templates) !!}
        });
    };
</script>
@endsection
@section('js')

    @include($__templates.'datetime')
    <script src="{{asset('js/admin/trips.js')}}"></script>
@endsection