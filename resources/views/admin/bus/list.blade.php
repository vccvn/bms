
@extends($__layouts.'main')

@section('title', 'Quản lý xe')

@section('content')
<?php 
$stt = ["Không hoạt động", 'Đang hoạt động'];
$types = [1 => 'Xe khách', 2 => 'Xe Buýt'];

$year = date('Y');
$month = date('m');
?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Quản lý xe
                        <a href="{{route('admin.bus.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        @include('admin._templates.search-filter',[
            'search_filter'=>[
                'license_plate' => 'Biển số',
                'route' => 'Tên tuyến',
                'start_station' => 'Bến xuất phát',
                'end_station' => 'Bến cuối',
                'to_province' => 'Tỉnh thành',
                'company' => 'Nhà xe'
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
                    <div class="item-col fixed item-col-check">
                        <span>Mã</span>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-title">
                        <div>
                            <span>Biển số</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Nhà xe</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Loại xe</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Số ghế</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-stats">
                        <div>
                            <span>Tải trọng</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-md item-col-stats">
                        <div>
                            <span>Tuyến</span>
                        </div>
                    </div>
                    
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Tần suất</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Lịch trình</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div>
                            <span>Trạng thái</span>
                        </div>
                    </div>
                    
                    
                    
                    
                    <div class="item-col item-col-header fixed item-col-stats"> 
                        <span>actions</span>
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
                    <div class="item-col fixed item-col-check">
                        <span>{{$item->id}}</span>
                    </div>
                    <div class="item-col fixed pull-left item-col-title item-col-same-sm">
                        <div class="item-heading">Biển kiểm soát</div>
                        <div>
                            
                            <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->license_plate}}"> 
                                <a href="{{$item->getUpdateUrl()}}" class="">{{$item->license_plate}} </a>
                            </h4>
                                
                            
                        </div>
                    </div>
                    
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Nhà xe</div>
                        <div class="no-overflow">
                            <span>{{$item->company}}</span>
                        </div>
                    </div>
                
                    <div class="item-col item-col-same-sm no-overflow item-col-stats">
                        <div class="item-heading">Loại xe</div>
                        <div class="no-overflow">
                            <span>{{$types[$item->type]}}</span>
                        </div>
                    </div>
                   
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Số ghế</div>
                        <div class="no-overflow">
                            <span>{{$item->seets}}</span>
                        </div>
                    </div>
                        
                    <div class="item-col no-overflow item-col-stats">
                        <div class="item-heading">Tải trọng</div>
                        <div class="no-overflow">
                            <span>{{$item->weight}} tấn</span>
                        </div>
                    </div>
                
                    <div class="item-col item-col-same-md no-overflow item-col-stats">
                        <div class="item-heading">Tuyến</div>
                        <div class="no-overflow">
                            <span>#{{$item->route_id}} {{$item->route}}</span>
                        </div>
                    </div>
                    
                            
                    <div class="item-col no-overflow item-col-same-sm item-col-stats">
                        <div class="item-heading">Tần suất hoạt động</div>
                        <div class="no-overflow">
                            <span>{{$item->freq_days}} ngày <br>{{$item->freq_trips}} chuyến</span>
                        </div>
                    </div>
                        
                    <div class="item-col no-overflow item-col-same-sm item-col-stats">
                        <div class="item-heading">Lịch Trình</div>
                        <div class="no-overflow">
                            <a href="{{route('admin.schedule.detail',['year'=>$year, 'month'=>$month, 'license_plate'=>$item->license_plate_clean])}}">Chi tiết</a>
                        </div>
                    </div>
                        
                    <div class="item-col no-overflow item-col-same-sm item-col-stats">
                        <div class="item-heading">Trạng thái</div>
                        <div class="no-overflow">
                            <span>{{$stt[$item->is_active]}}</span>
                        </div>
                    </div>
                        
                    
                    <div class="item-col fixed item-col-stats pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-right">
                                <li>
                                    <a href="{{$item->getUpdateUrl()}}" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}" title="xóa">
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
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.bus.delete')}}'
            }
        });
    };
</script>
@endsection

@section('is')
@if (session('message'))
<script>
    modal_alert('{{session('message')}}');
</script>
@endif

@endsection