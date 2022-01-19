<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @yield('title', 'Profile') | {{$siteinfo->site_name}} </title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{asset('themes/addmin/apple-touch-icon.png')}}">
    @include('user.profile.templates.css')

    @yield('css')
</head>

<body>
    <div class="main-wrapper">
        <div class="app" id="app">
            
            @include('panel._templates.header') 

            @include('user.profile.templates.sidebar')
            
            @yield('content')
            
            @include('panel._templates.footer')
            
            @include('user.profile.templates.modals')

            @yield('modal')

        </div>
    </div>
    @yield('jsinit')
    @include('panel._templates.theme-js')
    @include('panel._templates.js')
    @yield('js')
</body>

</html>