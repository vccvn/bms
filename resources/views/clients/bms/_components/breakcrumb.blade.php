
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




        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach ($breadcrumb as $item)
                <li class="breadcrumb-item {{$loop->last?:'active'}}">
                    @if ($loop->last)
                    {{$item['text']}}
                    @else
                    <a href="{{$item['url']}}">{{$item['text']}}</a>    
                    @endif
                    
                </li>    
                @endforeach
                
                
            </ol>
        </nav>
