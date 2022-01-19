<?php
use Cube\Html\Form;
use Cube\Html\HTML;
$title = isset($title)?$title:"cubeAdmin";

$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
$fm = new Cube\Arr($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):'';
$ft = isset($form_type)?$form_type:$form_action;

$form_properties = [
    'id' => $formid, 
    'method' => 'POST',
    'enctype'=> "multipart/form-data", 
    'action' => $fmact,
    'novalidate' => 'true',
    'form_group' => 'div',
    'form_group_class' => 'form-group',
    'use_label' => true,
    'label_class' => 'form-control-label',
    'input_wrapper' => null,
    'input_class' => 'form-control underlined',
    'input_error_class' => 'has-error is-invalid',
    'error_tag' => 'span',
    'error_class' => 'has-error',
    'btn_submit_text' => 'Lưu',
    'btn_submit_id' => 'btn-submit',
    'btn_submit_class' => 'btn btn-primary',
    'btn_group' => 'div',
    'btn_group_class' => 'form-group',
    'btn_wrapper' => null,
];

$form = new Form($formJSON,$fieldList, $fd, $errors, $form_properties);
$form->addAction(function($formgroup,$input) use ($ft){
    $t = $input->type;
    $formgroup->id = 'form-group-'.$input->name;
    $formgroup->inputWrapper->tagName=null;
    if(in_array($t,['checkbox','checklist','radio','button','submit','reset','image'])){
        $input->removeClass('form-control');
    }
    if($formgroup->hasError()){
        $formgroup->addClass('has-error');
    }

    if($t=='password'){
        $input->value='';
    }

    $formgroup->label->attr('id', 'label-for-'.$input->id);
})
->buttonSubmit($btnSaveText)
->buttonAction(function($submit,$cancel,$btngroup) use ($ft,$fm){
    $cancel->remove();
    $submit->addClass('btn-block');

    if($ft=='forgot'){
        $links = HTML::div(null,['class'=>'form-group clearfix']);
        $links->append($login = HTML::a(route('login'),'Trở lại trang đăng nhập', ['class'=>'pull-left']))
              ->append($login = HTML::a(route('register'),'Đăng ký mới', ['class'=>'pull-right']));

        $btngroup->after($links);

    }


    elseif($ft=='login'){
        $links = HTML::div(null,['class'=>'form-group clearfix']);
        $links->append($label = HTML::label($remember = HTML::input('checkbox','remember','1',[
            'id' => 'remember',
            'class'=>'checkbox',
            'checked' => (old('remember',$fm->get('remember'))?'true':null)
        ])))
              ->append($forgot = HTML::a(route('forgot'),'Quên mật khẩu', ['class'=>'forgot-btn pull-right']));
        $remember->after(' <span>Nhớ mật khẩu</span>');

        $btngroup->before($links);
        $btngroup->after($signup = HTML::div($text = HTML::p(
            'Bạn chưa có tài khoản?
            ',['class'=>'text-muted text-center']),[
            'class'=>'form-group'
        ]));
    }
    
    
    
    elseif($ft=='register'){
        $links = HTML::div(null,['class'=>'form-group clearfix']);
        $links->append($label = HTML::label($agree = HTML::input('checkbox','agree','1',[
            'id' => 'agree',
            'class'=>'checkbox',
            'checked' => (old('agree',$fm->get('agree'))?'true':null)
        ])));
        $agree->after(' <span>Đồng ý với các </span>');
        $agree->after($forgot = HTML::a('#','điều khoản'));

        $btngroup->before($links);
        $btngroup->after($signup = HTML::div($text = HTML::p(
            'Bạn đã có tài khoản?
            ',['class'=>'text-muted text-center']),[
            'class'=>'form-group'
        ]));
        $text->append(HTML::a(route('login'),'Đăng nhập'));
    }

});

?>

@extends('panel._layouts.auth')

@section('title', $title)

@section('content')
    <p class="text-center">{!! ($ft=='forgot')?"Đặt lại mật khẩu":(($ft=='login')?"Vui lòng đăng nhập để tiếp tục":(($ft=='reset')?"Đặt lại mật khẩu":"Đăng ký tài khoản mới")) !!}</p>
    {!! ($ft=='forgot')?'<p class="text-muted text-center">
        <small>Nhập email của bạn để lấy lại mật khẩu</small>
    </p>
    ':'' !!}
@if(session('register'))
<div class="alert alert-success underline">
    {{session('register')}}
</div>
@endif

@if(session('error'))
<div class="alert alert-warning underline">
    {{session('error')}}
</div>
@endif

{!! $form !!}


@endsection

