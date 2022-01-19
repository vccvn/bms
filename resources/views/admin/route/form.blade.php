<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;
$fmact = isset($form_action)?route($form_action):'';
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
                    <h3 class="title"> 
                        {{$title}}
                        
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    <!-- {{$errors->first()}} -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> {{isset($form_title)?$form_title:$title}} </h3>
            </div>
            <form id="{{$form_id}}" method="POST" action="{{$fmact}}" enctype="multipart/form-data"  novalidate="true">
                @csrf
                <input type="hidden" name="id" id="input-hidden-id" value="{{old('id', $form->id)}}">
                @foreach($inputs->get() as $input)
                    @php 
                    if(!$input) continue;
                    $name = $input->name;
                    $t = $input->type;
                    @endphp
                    @if($t=='hidden')
                        {!!$input!!}
                        <!-- {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!} -->

                    @else
                        <div class="form-group row {{$input->error?'has-error':''}}" id="form-group-{{$name}}">
                            <label for="{{$input->id}}" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 {{$input->required?'required':''}}" id="label-for-{{$name}}">{{$input->label}}</label>
                            <div class="input-{{$t}}-wrapper col-sm-8 col-md-9 col-lg-8 col-xl-9">
                                @if($t=='image')
                                    <div class="input-group">
                                        <input class="input-file-fake form-control" readonly="true" type="text" name="{{$input->name}}_show" value="{{$input->val()}}">
                                        <button type="button" class="input-group-addon btn-select-file bg-warning">Chọn file</button>
                                    </div>
                                @elseif(in_array($name,['time_start', 'time_end', 'time_between']))
                                    <div class="input-group datetimepicker-group">
                                        {!! $input !!}
                                        <div class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </div>
                                    </div>
                                @else
                                    {!!$input!!}
                                @endif
                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-sm-4 col-lg-3"></div>
                    <div class="col-sm-8 col-lg-9">
                        <button class="btn btn-primary" type="submit">{{$btnSaveText}}</button> 
                        <button class="btn btn-danger btn-cancel" type="button">Hủy</button>
                    </div>
                    
                </div>
                
            </form>
            
                
        </div>
    </div>


</article>

@endsection


@section('css')
    <style>
    label.required::after{
        content:"*";
        display: inline-block;
        color: #f00;
        margin-left: 5px;
        font-size: 1rem;
        line-height: 1.5;
    }
    </style>
@endsection



@section('jsinit')
<script>
    window.routesInit = function() {
        Cube.routes.init({
            urls:{
                get_options_url: '{{route('admin.station.option')}}',
                get_end_options_url: '{{route('admin.station.end-option')}}',
            }
        });
    };
</script>
@endsection

@section('js')

    @include($__templates.'datetime')
    <script src="{{asset('js/admin/routes.js')}}"></script>
@endsection
