

<!-- seo -->
<link rel="canonical" href="{{url()->current()}}" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="@yield('page.type', 'website')" />
<meta property="og:title" content="@yield('meta_title', $__env->yieldContent('title', "Trang chủ").' | '.$siteinfo->site_name?$siteinfo->site_name:'Light Solution'))" />
<meta property="og:description" content="@yield('meta_description', $__env->yieldContent('description', $siteinfo->description))" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{{$siteinfo->site_name}}" />
@if($__env->yieldContent('page.type') == 'article')

<meta property="article:publisher" content="{{$siteinfo->facebook}}" />
<meta property="article:section" content="@yield('article_section', 'Tin tức')" />
<meta property="article:published_time" content="@yield('published_time','2018-04-22T19:48:13+07:00')" />
<meta property="article:modified_time" content="@yield('modified_time','2018-04-22T19:48:13+07:00')" />
<meta property="og:updated_time" content="@yield('modified_time','2018-04-22T19:48:13+07:00')" />
<meta property="og:image" content="@yield('image', $siteinfo->image)" />
<meta property="og:image:width" content="480" />
<meta property="og:image:height" content="320" />
@endif

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="@yield('description', $siteinfo->description)" />
<meta name="twitter:title" content="@yield('title', "Trang chủ") | {{$siteinfo->site_name?$siteinfo->site_name:'Light Solution'}}" />
<meta name="twitter:site" content="@yield('twitter_site', $siteinfo->twitter_site)" />
<meta name="twitter:image" content="@yield('image', $siteinfo->image)" />
<meta name="twitter:creator" content="@yield('twitter_site', $siteinfo->twitter_creator)" />
<script type='application/ld+json'>{!!json_encode([
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "url" => url('/'),
    "sameAs"=>[$siteinfo->facebook,$siteinfo->twitter],
    "@id" => url('/')."#organization",
    "name" => $siteinfo->site_name,
    "logo" => $siteinfo->logo
]) !!}</script>
<!-- / SEO  -->
