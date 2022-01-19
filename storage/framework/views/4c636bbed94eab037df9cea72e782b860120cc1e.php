<div class="main-slider">
    <div class="bms-carousel owl-carousel owl-theme main-slider-container" data-margin="0" data-show="1" data-autoplay="true" data-hover-pause="true" data-speed="1000" data-timeout="5000" data-loop="true" data-nav="true">
        <?php if($home_slider && $home_slider->items): ?>
            <?php
                $items = $home_slider->items;
            ?>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <div class="item" style="background-image: url(<?php echo e($item->getImage()); ?>)">
                <div class="item-content">
                    <div class="container">
                        <div class="item-content-detail">
                            <h3><?php echo e($item->title); ?></h3>
                            <p><?php echo nl2br($item->description); ?></p>
                            <?php if($item->link): ?>
                            <a href="<?php echo e($item->link); ?>" class="btn btn-skew">Xem thêm</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="item" style="background-image: url(<?php echo e(theme_url('assets/images/slide1.jpg')); ?>)">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 1</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image: url(<?php echo e(theme_url('assets/images/slide2.jpg')); ?>)">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 2</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image: url(<?php echo e(theme_url('assets/images/slide1.jpg')); ?>)">
            <div class="item-content">
                <div class="container">
                    <div class="item-content-detail">
                        <h3>Slider 3</h3>
                        <p>tests</p>
                        <a href="#" class="btn btn-skew">Xem thêm</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>