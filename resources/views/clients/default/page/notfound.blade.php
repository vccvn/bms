<?php 
$category = isset($parent)?$parent:null;

?>

@extends($__layouts.'sidebar')

@include($__utils.'register-meta')


@section('content')

    <div class="alert alert-danger">Trang bạn truy cập hiện không khả dụng</div>
                

@endsection
