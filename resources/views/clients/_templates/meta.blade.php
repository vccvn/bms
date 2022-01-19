
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title', "Trang chủ") | {{$siteinfo->site_name?$siteinfo->site_name:'Light Solution'}}</title>
    <meta property="og:site_name" content="{{$siteinfo->site_name}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   

    <meta name="title" content="@yield('meta_title', $__env->yieldContent('title', "Trang chủ").' | '.$siteinfo->site_name?$siteinfo->site_name:'Light Solution'))">
    <meta name="description" content="@yield('meta_description', $__env->yieldContent('description', $siteinfo->description))">
    <meta name="keywords" content="@yield('keywords', $siteinfo->keywords)">
    <meta name="image" content="@yield('image', $siteinfo->image)">

    {{-- meta seo --}}
    
    @include('clients._templates.meta-seo')
    
    {{-- end meta seo --}}
