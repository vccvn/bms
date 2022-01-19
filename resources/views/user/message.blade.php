@extends('panel._layouts.auth')

@section('title', 'Thông báo')

@section('content')

@php
$t = $type?$type:'success';

@endphp

<p class="alert alert-{{$t}}">{{$message}}</p>

<div class="text-center">
	@if(!isset($link) || !$link)
		<a href="{{url('/')}}" class="btn btn-primary">Về trang chủ</a>
	@else
		<a href="{{$link}}" class="btn btn-primary">{{$text?$text:"Go"}}</a>
	@endif
</div>

@endsection

