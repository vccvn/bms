<?php
$title = isset($title)?$title:"cubeAdmin";
?>

@extends('admin.layout.main')

@section('title', $title)

@section('page.name','app')

@section('page.type', 'app')

@section('content')

<div class="card card-block sameheight-item">
    <div class="title-block">
        <h3 class="title"> {{isset($formtitle)?$formtitle:$title}} </h3>
    </div>
    <?php
    use Cube\Html\Form as HtmlForm;
    if(isset($formdata)){
        $fd = $formdata;
    }
    else{
        $fd = null;
    }
    $form = new Cube\Arr($fd); //tao mang du lieu

    $fm_a = isset($form_action)?route($form_action):'';

    $form = new HtmlForm('test','*', $fd,$errors,[
        'method' => 'POST',
        'enctype'=> "multipart/form-data", 
        'action' => $fm_a,
        'attrs' => ['novalidate' => true],
        'form_type' => 'laravel',
        'style' => 'bootstrap'
    ]);
    $form->addAction(function($formgroup,$input){
        $t = $input->type;
        if(in_array($t,['checkbox','radio','button','submit','reset','image'])){
            $input->removeClass('form-control');
        }
        $formgroup->label->attr('for', 'label-for-'.$input->id);
    });
    ?>
    {!! $form !!}
        
</div>

@endsection

@section('js')
    <script>
        function checkDataType(){
            var t = $('#data').val();
            var text = '';
            var dis = 'block';
            if(t=='json'){
                text = "filename";
            }else if(t=='define'){
                text = "Hàm / Phương thức"
            }else{
                dis = 'none';
            }
            $('#label-for-data').htnl(text);
            $('#form-group-data').css('display',dis);
        }
        $(function(){
            checkDataType();
            $('select#data').change(checkDataType);
        });
    </script>
@endsection