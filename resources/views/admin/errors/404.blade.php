@extends('panel._layouts.clean')

@section('title', '404 - Page not Found')


@section('content')


<div class="app blank sidebar-opened">
    <article class="content">
        <div class="error-card global">
            <div class="error-title-block">
                <h1 class="error-title">404</h1>
                <h2 class="error-sub-title"> Page not Found. </h2>
            </div>
            <div class="error-container">
                <p>Why not try refreshing your page? or you can contact support</p>
                <a class="btn btn-primary" href="#">
                    <i class="fa fa-angle-left"></i> Back to website </a>
            </div>
        </div>
    </article>
</div>

@endsection