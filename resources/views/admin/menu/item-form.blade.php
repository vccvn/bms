<?php
use Cube\Html\Form;
use Cube\Html\HTML;

$title = isset($title)?$title:"cubeAdmin";
$fd = isset($formdata)?$formdata:null; // form data
$formid = 'item-form';
$fmact = isset($form_action)?route($form_action):'';
$form_properties = [
    'id' => $formid, 
    'method' => 'POST',
    'enctype'=> "multipart/form-data", 
    'action' => $fmact,
    'novalidate' => 'true',
    'form_type' => 'laravel',
    'style' => 'bootstrap'
];

$form = new Form($formJSON,$fieldList, $fd, $errors, $form_properties);

$form->addAction(function($formgroup,$input){
    $t = $input->type;
    $formgroup->id = 'form-group-'.$input->name;
    $formgroup->inputWrapper->addClass('input-'.$t.'-wrapper');
    if(in_array($t,['checkbox','checklist','radio','button','submit','reset','image'])){
        $input->removeClass('form-control');
    }
    if($formgroup->hasError()){
        $formgroup->addClass('has-error');
    }
    $formgroup->label->attr('id', 'label-for-'.$input->id);
})
->buttonSubmit($btnSaveText);

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
                    <h3 class="title"> {{$title}}
                        @isset($back_link) 
                            <a href="{{$back_link}}" class="btm btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        @endisset
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> {{isset($form_title)?$form_title:$title}} </h3>
            </div>
            {!! $form !!}
                
        </div>
    </div>


</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-select/css/bootstrap-select.css')}}" />

@endsection

@section('jsinit')
<script>
    window.menuItemsInit = function() {
        Cube.menuItems.init({
            urls:{
                change_priority_url:  '{{route('admin.menu.item.change-priority')}}',
            }
        });
    };
</script>
@endsection

@section('js')
    <script src="{{asset('js/admin/menu.items.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    @include($__templates.'form-js')


@endsection