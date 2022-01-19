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
?>




        <section class="page-title" style="background-image: url({{get_theme_url('images/background/4.jpg')}});">
            <div class="auto-container">
                <h1>{{in_array($t,['category','product'])?$object->name:(($t!='text' && !is_null($t))?$object->title:$object)}}</h1>
                <ul class="bread-crumb">
                    <li><a href="{{route('home')}}">Home</a></li>
                    @if(in_array($t,['article','product']))
                        @if($t=='article' && in_array($object->type, ['dynamic','page']))
                            @if($parent = $object->getParent())
                                <li><a href="{{$parent->getViewUrl()}}">{{$parent->title}}</a></li>
                            @endif
                        @else
                            @if($t=='product')
                            <li><a href="{{route('client.product')}}">Sản phẩm</a></li>
                            @endif
                            <?php $cat = $object->category; ?>
                            @if($parent = $cat->getParent())
                            <li><a href="{{$parent->getViewUrl()}}">{{$parent->name}}</a></li>
                            @endif
                            <li><a href="{{$cat->getViewUrl()}}">{{$cat->name}}</a></li>
                        @endif
                    @elseif($t == 'category')
                        @if($object->type=='product')
                        <li><a href="{{route('client.product')}}">Sản phẩm</a></li>
                        @endif
                        
                        @if($parent = $object->getParent())
                        <li><a href="{{$parent->getViewUrl()}}">{{$parent->name}}</a></li>
                        @endif
                    @endif
                    @if($t!='text' && !is_null($t))
                    <li><a href="{{$object->getViewUrl()}}">{{in_array($t,['category','product'])?$object->name:$object->title}}</a></li>
                    @else
                    <li><a  href="#">{{$object}}</a></li>
                    @endif
                </ul>
            </div>
        </section>

