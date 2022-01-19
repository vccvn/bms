<?php 
$category = isset($parent)?$parent:null;

?>

@extends($__layouts.'sidebar')
{{-- meta --}}

@include($__utils.'register-meta')

{{-- /meta --}}

@section('content')

                    <!--News details-->
                    <div class="alert alert-danger">Trang bạn truy cập hiện không khả dụng</div>
                

@endsection
