<?php
use Cube\Html\Input;

use App\Repositories\Stations\StationRepository;
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

@extends($__layouts.'single')

@section('title','Tra lịch trình')

@section('content')

        <div class="trip-page">
            @include($__templates.'trip-form')
            <section class="results">
                <div class="container result-data">
                    @include($__current.'results')
                    
                </div>
            </section>
        </div>
            
@endsection
@section('jsinit')
<script>
    window.tripsInit = function() {
        Cube.trips.init({
            urls:{
                ajax_search:  '{{route('client.trip.ajax-search')}}',
                ajax_detail:  '{{route('client.trip.detail')}}'
            }
        });
    };
</script>
@endsection
@section('js')
@include($__utils.'datetime')
<script src="{{asset('js/client/trips.js')}}"></script>
@endsection