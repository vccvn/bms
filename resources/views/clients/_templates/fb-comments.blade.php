<?php
$u = isset($url)?$url:(isset($link)?$link:'');
$w = isset($width)?$width:'100%';
$n = isset($show)?$show:'10';
?>
<style>
    .facebook-comments{
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="facebook.comments">
    <div 
        class="fb-comments" 
        data-href="{{$u}}" 
        data-width="{{$w}}" 
        data-numposts="{{$n}}"
    ></div>
</div>