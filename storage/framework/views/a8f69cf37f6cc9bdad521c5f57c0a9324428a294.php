
<?php if($partner_slider && $partner_slider->items): ?>
<?php
    $items = $partner_slider->items;
?>

        <section class="sponsors-style-one">
            <div class="auto-container">
                <div class="sec-title center">
                    <h2>Khách hàng & <span class="theme_color">Đối tác</span> </h2>
                    <span class="separator"></span>
                </div>
                <!--Sponsors Slider-->
                <ul class="sponsors-carousel-one owl-theme owl-carousel">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <li>
                        <div class="image-box tool_tip" title="media partner">
                            <a href="<?php echo e($item->link); ?>"><img src="<?php echo e($item->getImage()); ?>" alt="<?php echo e($item->title); ?>"></a>
                        </div>
                    </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <li>
                        <div class="image-box tool_tip" title="media partner">
                            <a href="<?php echo e($item->link); ?>"><img src="<?php echo e($item->getImage()); ?>" alt="<?php echo e($item->title); ?>"></a>
                        </div>
                    </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </ul>
            </div>
        </section>

<?php endif; ?>