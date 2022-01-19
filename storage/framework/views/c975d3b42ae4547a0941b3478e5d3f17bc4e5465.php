    <div id="search-popup" class="search-popup">
        <div class="close-search theme-btn"><span class="fa fa-close"></span></div>
        <div class="popup-inner">

            <div class="search-form">
                <form method="get" action="<?php echo e(route('client.search')); ?>">
                    <div class="form-group">
                        <fieldset>
                            <input type="search" class="form-control" name="s" value="" placeholder="Nhập từ khóa...." required>
                            <input type="submit" value="Tìm kiếm" class="theme-btn">
                        </fieldset>
                    </div>
                </form>

                <br>
                <?php if($tags = get_popular_tags(['@limit'=>6])): ?>
                <h3>Từ khóa nổi bật</h3>
                <!-- Tags -->
                <ul class="recent-searches">
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><a href="<?php echo e(route('client.search',['s'=>$tag->lower])); ?>"><?php echo e($tag->keywords); ?></a></li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                
                <?php endif; ?>
                
            </div>

        </div>
    </div>