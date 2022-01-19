
<?php if($home_slider && $home_slider->items): ?>
    <?php
        $items = $home_slider->items;
    ?>

        <section class="main-slider" data-start-height="700" data-slide-overlay="yes">

            <div class="tp-banner-container">
                <div class="tp-banner">
                    <ul>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="<?php echo e($item->getImage()); ?>" data-saveperformance="off" data-title="<?php echo e($item->title); ?>">
                            <img src="<?php echo e($item->getImage()); ?>" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

                            <div class="tp-caption sfl sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="-100" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <h2 class="light"><?php echo e($item->title); ?></h2>
                            </div>


                            <div class="tp-caption sfr sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="20" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <div class="text light"><?php echo nl2br($item->description); ?></div>
                            </div>

                            <div class="tp-caption sfl sfb tp-resizeme" data-x="left" data-hoffset="15" data-y="center" data-voffset="110" data-speed="1500" data-start="0" data-easing="easeOutExpo" data-splitin="none" data-splitout="none" data-elementdelay="0.01" data-endelementdelay="0.3"
                                data-endspeed="1200" data-endeasing="Power4.easeIn">
                                <div class="btn-box">
                                    <a href="<?php echo e($item->link); ?>" class="theme-btn btn-style-one">Chi tiết</a>
                                    
                                </div>
                            </div>

                        </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                    <div class="tp-bannertimer"></div>
                </div>
            </div>
        </section>

<?php endif; ?>