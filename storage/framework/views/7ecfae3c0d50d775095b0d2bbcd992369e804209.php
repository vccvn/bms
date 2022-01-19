
<?php
    
$obj = isset($article)?[$article, 'article']:(
    isset($product)?[$product, 'product']:(
        isset($category)?[$category,'category']:(
            isset($page_name)?[$page_name,"text"]:(
                $__env->yieldContent('title')?[$__env->yieldContent('title'),'text']:[
                    null, null
                ]
            )
        )
    )

);
$object = $obj[0];
$t = $obj[1];

$breadcrumb = [
    [
        'url' => route('home'),
        'text' => 'Trang chủ'
    ]
];
// neu la bai viet hoacv san pham
if(in_array($t,['article','product'])){
    if($t=='article' && in_array($object->type, ['dynamic','page'])){
        // neu la dynamuic hoac page
        if($parent = $object->getParent()){
            $breadcrumb[] = [
                'url' => $parent->getViewUrl(),
                'text' => $parent->title
            ];
        }
    }else{
        if($t=='product'){
            $breadcrumb[] = [
                'url' => route('client.product'),
                'text' => 'Sản phẩm'
            ];
        }
        $cat = $object->category;
        if($parent = $cat->getParent()){
            $breadcrumb[] = [
                'url' => $parent->getViewUrl(),
                'text' => $parent->name
            ];
        }
        $breadcrumb[] = [
            'url' => $cat->getViewUrl(),
            'text' => $cat->name
        ];
    }

}elseif($t == 'category'){
    if($object->type=='product'){
        if($t=='product'){
            $breadcrumb[] = [
                'url' => route('client.product'),
                'text' => 'Sản phẩm'
            ];
        }
        
    }
    
    if($parent = $object->getParent()){
        $breadcrumb[] = [
            'url' => $parent->getViewUrl(),
            'text' => $parent->name
        ];
    }
    
    
}
if($t!='text' && !is_null($t)){
    $breadcrumb[] = [
        'url' => $object->getViewUrl(),
        'text' => in_array($t,['category','product'])?$object->name:$object->title
    ];
}
else{
    $breadcrumb[] = [
        'url' => '#',
        'text' => $object
    ];
}


?>


<div class="page-header" style="background-image: url(<?php echo e($siteinfo->page_cover_image(theme_asset('images/slide3.jpg'))); ?>);">
        
    <div class="info-page container">
        <h2 class="title-page">
            <?php echo e(in_array($t,['category','product'])?$object->name:(
                    ($t!='text' && !is_null($t))?$object->title:$object
                )); ?>

        </h2>
        <div class="list-inline bread-crumb">
            <ul>
                <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="<?php echo e($loop->last?'active':''); ?>">
                    <?php if($loop->last): ?>
                    <?php echo e($item['text']); ?>

                    <?php else: ?>
                    <a href="<?php echo e($item['url']); ?>"><?php echo e($item['text']); ?></a>    
                    <?php endif; ?>
                    
                </li>    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    
</div>