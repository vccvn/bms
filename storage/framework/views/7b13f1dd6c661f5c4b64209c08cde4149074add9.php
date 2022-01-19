

<!-- seo -->
<link rel="canonical" href="<?php echo e(url()->current()); ?>" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="<?php echo $__env->yieldContent('page.type', 'website'); ?>" />
<meta property="og:title" content="<?php echo $__env->yieldContent('meta_title', $__env->yieldContent('title', "Trang chủ").' | '.$siteinfo->site_name?$siteinfo->site_name:'Light Solution'); ?>)" />
<meta property="og:description" content="<?php echo $__env->yieldContent('meta_description', $__env->yieldContent('description', $siteinfo->description)); ?>" />
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:site_name" content="<?php echo e($siteinfo->site_name); ?>" />
<?php if($__env->yieldContent('page.type') == 'article'): ?>

<meta property="article:publisher" content="<?php echo e($siteinfo->facebook); ?>" />
<meta property="article:section" content="<?php echo $__env->yieldContent('article_section', 'Tin tức'); ?>" />
<meta property="article:published_time" content="<?php echo $__env->yieldContent('published_time','2018-04-22T19:48:13+07:00'); ?>" />
<meta property="article:modified_time" content="<?php echo $__env->yieldContent('modified_time','2018-04-22T19:48:13+07:00'); ?>" />
<meta property="og:updated_time" content="<?php echo $__env->yieldContent('modified_time','2018-04-22T19:48:13+07:00'); ?>" />
<meta property="og:image" content="<?php echo $__env->yieldContent('image', $siteinfo->image); ?>" />
<meta property="og:image:width" content="480" />
<meta property="og:image:height" content="320" />
<?php endif; ?>

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="<?php echo $__env->yieldContent('description', $siteinfo->description); ?>" />
<meta name="twitter:title" content="<?php echo $__env->yieldContent('title', "Trang chủ"); ?> | <?php echo e($siteinfo->site_name?$siteinfo->site_name:'Light Solution'); ?>" />
<meta name="twitter:site" content="<?php echo $__env->yieldContent('twitter_site', $siteinfo->twitter_site); ?>" />
<meta name="twitter:image" content="<?php echo $__env->yieldContent('image', $siteinfo->image); ?>" />
<meta name="twitter:creator" content="<?php echo $__env->yieldContent('twitter_site', $siteinfo->twitter_creator); ?>" />
<script type='application/ld+json'><?php echo json_encode([
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "url" => url('/'),
    "sameAs"=>[$siteinfo->facebook,$siteinfo->twitter],
    "@id" => url('/')."#organization",
    "name" => $siteinfo->site_name,
    "logo" => $siteinfo->logo
]); ?></script>
<!-- / SEO  -->
