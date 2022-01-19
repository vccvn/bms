<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$types = ['province' => 'Tỉnh','city' => 'Thành Phố'];
if($route->type == 'bus'){
    $inputs->province_id->type='hidden';
}
?>


@extends($__layouts.'main')

@section('title', 'Tuyến đường: '.$route->name)

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> 
                            <a href="javascript:window.history.back();" class="btn btn-primary btn-sm rounded-s"> <i class="fa fa-angle-left"></i> </a>
                        {{$route->name}} 
                        
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
    <div class="row">
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <div class="card items">
                <div class="card-block">
                    <div class="title-block">
                        <h3 class="title"> Hành trình: <span class="pr-3">Bến xe {{$route->start_station . " ($route->from_province)"}}</span> <i class="fa fa-exchange"></i> <span class="pl-3">Bến xe {{$route->end_station . " ($route->to_province)"}}</span> </h3>
                    </div>
                    <div class="cf nestable-lists passing-list">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                @foreach($journeys as $item)
    
                                <li class="dd-item" data-id="{{$item->id}}" id="item-{{$item->id}}">
                                    <div class="item-actions">
                                        <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                    <div class="dd-handle" id="item-name-{{$item->id}}" data-name="{{$item->place_name}}">{{$item->place_name}} ({{$item->province_name}})</div>

                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>

        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="text-white mb-0"> Thêm Địa điểm </p>
                    </div>
                </div>
                <div class="card-block">
                    <form id="add-passing-place-form" method="POST" action="{{route('admin.place.add-passing-place')}}"  novalidate="true">
                        @foreach($inputs->get() as $inp)
                        <div class="form-group {{$inp->error?'has-error':''}}" id="form-group-{{$inp->name}}">
                            @if(!in_array($inp->type,['radio','checkbox','checklist', 'hidden']))
                            <label for="{{$inp->id}}" class="form-control-label" id="label-for-{{$inp->name}}">{{$inp->label}}</label>
                            @else
                            <?php $inp->removeClass('form-control'); ?>
                            @endif
                            @if ($inp->type=='hidden')
                                {!! $inp !!}
                            @else
                                <div class="input-{{$inp->type}}-wrapper">
                                        {!! $inp !!}
            
                                    {!! $inp->error?(HTML::span($inp->error,['class'=>'has-error'])):'' !!}
            
                                </div>    
                            @endif
                            
                        </div>
                        @endforeach
        
                        <div class="mt-4 text-center">
                            <button class="btn btn-primary" type="submit">Thêm</button>
                        </div>
                    </form>        
                </div>
            </div>



        </div>
    </div>
    
    
</article>

@endsection


@section('css')
    <link rel="stylesheet" href="{{asset('css/nestable2.css')}}" />
@endsection

@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.place.delete-passing')}}'
            }
        });
    };

    window.journeyInit = function() {
        Cube.journey.init({
            urls:{
                get_places_url: '{{route('admin.place.option')}}',
                sort_places_url: '{{route('admin.place.sort-place')}}',
                
            }
        });
    };
</script>
@endsection

@section('js')

    @include($__templates.'datetime')
    <script src="{{asset('js/admin/jquery.nestable.js')}}"></script>
    <script src="{{asset('js/admin/journey.js')}}"></script>


@endsection
