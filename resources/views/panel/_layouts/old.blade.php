<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @yield('title', 'Trang quản trị') | {{$siteinfo->site_name}} </title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{asset('themes/addmin/apple-touch-icon.png')}}">
    @include('profile.manager._templates.css')

    @yield('css')
</head>

<body>
    <div class="main-wrapper">
        <div class="app" id="app">
            
            @include('profile.manager._templates.header') 

            @include('profile.manager._templates.sidebar')
            
            <article class="content items-list-page">
            
                @include('profile.manager._templates.content-header')
            
                @yield('content')
            
            </article>
            
            @include('profile.manager._templates.footer')
            
            @include('profile.manager._templates.modals')

        </div>
    </div>
    @yield('jsinit')
    @include('profile.manager._templates.js')
    @yield('js')
</body>

</html>