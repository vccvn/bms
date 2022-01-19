<?php
use Cube\Any;
$route = $bus->route;
$title = 'Lịch trình: xe '.$bus->license_plate.', chạy tuyến '.$route->name;

$days = ['Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy', 'Chủ nhật'];

$the_day_after = $webSetting->schedule_days_before(0);

$time = strtotime(date('Y-m-d'));
$after_seven_day_time = $time + 3600*24*$the_day_after; 
$now = get_time_seconds();
$today = (int) date('d');
$day_after = $today + $the_day_after;
$s_month = (int) $month;
$d_month = (int) date('m');
$s_year = (int) $year;
$d_year = (int) date('Y');

$day_start = 0;
$day_stop = 31;
$disabled = false;
$md_month = ($s_year == $d_year && $s_month == $d_month)?true:false;
if($s_year >= $d_year){
    if($s_year == $d_year && $s_month < $d_month){
        $disabled = true;
    }
    elseif($bus->date_limited){
        $day_start = ($d_year != $s_year || $d_month != $s_month || $bus->day_start > $today) ? $bus->day_start : $today;
        $day_stop = $bus->day_stop;
    }else{
        $day_start = ($s_year == $d_year && $md_month && $today > $bus->day_start)?$today:$bus->day_start;
    }
}else{
    $disabled = true;
}
$freq_days = $bus->freq_days;
$time_start = $route->time_start;
$time_end = $route->time_end;
$time_between = $route->time_between;
$month_trips = $route->month_trips;
$freq_trips = $bus->freq_trips;

$days_available = [];

$go_forward = old('forward_date',[]);
if(!$go_forward && !old('bus_id')){
    $go_forward = $forwards;
}

$go_back = old('back_date',[]);
if(!$go_back && !old('bus_id')){
    $go_back = $backs;
}

$before_seven_day = true;
if($d_year == $s_year){
    if(strtotime("$d_year-$d_month-1")<$after_seven_day_time){
        $before_seven_day = false;
    }
}
if(isset($calendar) && is_array($calendar)){
    foreach ($calendar as $week) {
        foreach ($week as $day) {
            $d = new Any($day); 
            $t = $d->type == 'day';
            
            $disable = ($disabled || $d->type != 'day' || ($s_year == $d_year && (($md_month && $d->day < $today) || $d->day > $day_stop)) || $d->time < $after_seven_day_time || $d->day < $day_start) ? true : false;
            if(!$disable){
                $days_available[] = $d->day;
            }
        }
    }

}

$prev_month = $month-1;
if($prev_month==0){
    $prev_month = 12;
    $prev_year = $year-1;
}else{
    $prev_year = $year;
}

$next_month = $month+1;
if($next_month==13){
    $next_month = 1;
    $next_year = $year+1;
}else{
    $next_year = $year;
}

$types = [1 => 'Xe khách', 2 => 'Xe Buýt'];

$st = ($route->type == 'direct' || ($route->type=='bus' && in_array(get_station_id(), [$route->from_id, $route->to_id])))? 'trình' : 'ghé bến';

?>

@extends($__layouts.'main')

@section('title', $title)

@section('content')

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block text-center">
            <h3 class="title text-center"> 
                <a href="{{route('admin.schedule.detail',['year'=>$prev_year, 'month'=>$prev_month, 'license_plate'=>$bus->license_plate_clean])}}" class="btn btn-primary btn-sm rounded-s d-none d-md-inline mr-1"> <i class="fa fa-angle-left"></i> </a>
                
                Lịch {{$st}} của {{$types[$bus->type]}} {{$bus->license_plate}} tháng {{$month}}/{{$year}}
                
                <a href="{{route('admin.schedule.detail',['year'=>$next_year, 'month'=>$next_month, 'license_plate'=>$bus->license_plate_clean])}}" class="btn btn-primary btn-sm rounded-s d-none d-md-inline"> <i class="fa fa-angle-right"></i> </a>
            </h3>
            <div class="d-md-none">
                <a href="{{route('admin.schedule.detail',['year'=>$prev_year, 'month'=>$prev_month, 'license_plate'=>$bus->license_plate_clean])}}" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-left"></i> </a>
                <a href="{{route('admin.schedule.detail',['year'=>$next_year, 'month'=>$next_month, 'license_plate'=>$bus->license_plate_clean])}}" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-right"></i> </a>
            </div>
            @if (!$before_seven_day && $the_day_after)
                <p class="text-danger">
                    * Lưu ý: Bạn chỉ có thể đặt lịch muộn nhất trước {{$the_day_after}} ngày!
                </p>
            @endif
    
        </div>
        
    </div>
    <!-- list content -->
    <!-- {{$errors->first()}} -->
    
        <form action="{{route('admin.schedule.save')}}" method="post">
            @csrf
            <input type="hidden" name="bus_id" value="{{$bus->id}}">
            <input type="hidden" name="month" value="{{$month}}">
            <input type="hidden" name="year" value="{{$year}}">
            
            <div class="row schedule">
                <div class="col-md-6 go-forward">
                    @include('admin.schedule.forward')
                </div>
                <div class="col-md-6 go-back">
                    @include('admin.schedule.back')
                </div>

            </div>
            <div class="form-group mt-4 text-center">
                <button type="submit" class="btn btn-primary">Cập nhật lịch trình</button>
                <a href="{{route('admin.schedule.list',['year'=>$year,'month'=>$month])}}" class="btn btn-secondary">Hủy</a>
            </div>

        </form>

    

</article>

@endsection


@section('css')
    <link rel="stylesheet" href="{{asset('css/date-table.css')}}">
@endsection



@section('jsinit')
<?php 
$js_variables = compact(
    'day_start','day_stop','freq_days', 'time_start', 'time_end', 'time_between', 'month_trips', 'days_available'
);
?>
<script>
    window.schedulesInit = function(){
        Cube.schedules.init({!! json_encode($js_variables) !!});
    };
</script>
@endsection

@section('js')

    @include($__templates.'datetime')
    
<script src="{{asset('js/admin/schedules.js')}}"></script>

@if (session('message'))
<script>
    modal_alert('{{session('message')}}');
</script>
@endif
@endsection
