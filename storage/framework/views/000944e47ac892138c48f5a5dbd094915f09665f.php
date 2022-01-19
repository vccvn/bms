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




        <section class="page-title" style="background-image: url(<?php echo e(get_theme_url('images/background/4.jpg')); ?>);">
            <div class="auto-container">
                <h1><?php echo e(in_array($t,['category','product'])?$object->name:(($t!='text' && !is_null($t))?$object->title:$object)); ?></h1>
                <ul class="bread-crumb">
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <?php if(in_array($t,['article','product'])): ?>
                        <?php if($t=='article' && in_array($object->type, ['dynamic','page'])): ?>
                            <?php if($parent = $object->getParent()): ?>
                                <li><a href="<?php echo e($parent->getViewUrl()); ?>"><?php echo e($parent->title); ?></a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($t=='product'): ?>
                            <li><a href="<?php echo e(route('client.product')); ?>">Sản phẩm</a></li>
                            <?php endif; ?>
                            <?php $cat = $object->category; ?>
                            <?php if($parent = $cat->getParent()): ?>
                            <li><a href="<?php echo e($parent->getViewUrl()); ?>"><?php echo e($parent->name); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e($cat->getViewUrl()); ?>"><?php echo e($cat->name); ?></a></li>
                        <?php endif; ?>
                    <?php elseif($t == 'category'): ?>
                        <?php if($object->type=='product'): ?>
                        <li><a href="<?php echo e(route('client.product')); ?>">Sản phẩm</a></li>
                        <?php endif; ?>
                        
                        <?php if($parent = $object->getParent()): ?>
                        <li><a href="<?php echo e($parent->getViewUrl()); ?>"><?php echo e($parent->name); ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($t!='text' && !is_null($t)): ?>
                    <li><a href="<?php echo e($object->getViewUrl()); ?>"><?php echo e(in_array($t,['category','product'])?$object->name:$object->title); ?></a></li>
                    <?php else: ?>
                    <li><a  href="#"><?php echo e($object); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>

