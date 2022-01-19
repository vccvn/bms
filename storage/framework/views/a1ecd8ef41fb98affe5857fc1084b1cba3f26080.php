

<?php if($paginator->hasPages()): ?>
<div class="styled-pagination">
    <ul>
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="disabled"><a href="#"><span>&laquo;</span></a></li>
        <?php else: ?>
            <li class=" tran3s"><a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">&laquo;</a></li>
        <?php endif; ?>

        
        <?php
        $l = false;
        $r = false;
        $l2 = false;
        $r2 = false;
        $mp = 0;
        ?>
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php 
                $cp = $paginator->currentPage();
                $t = $paginator->lastPage();
            ?>
                
            
            <?php if(is_string($element)): ?>
                <?php if(!$l && !$l2 && $mp < $cp): ?> 
                    <?php 
                    $l = true;
                    $l2 = true; 
                    ?>
                    <li class="disabled"><a href="#"><span><?php echo e($element); ?></span></a></li>
                <?php elseif(!$r && !$r2 && $mp > $cp): ?>
                    <li class="disabled"><a href="#"><span><?php echo e($element); ?></span></a></li>
                    <?php 
                    $r = true; 
                    $r2 = true; 
                    ?>
                <?php endif; ?>
                
            <?php endif; ?>
            
            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $mp++; ?>
                    <?php if($page == 1 || ($page >= $cp-2 && $page <= $cp+2) || $page == $t): ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li><a href="#" class="active"><span><?php echo e($page); ?></span></a></li>
                        <?php else: ?>
                            <li class=" tran3s"><a href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php elseif($page < $cp-2 && $page > 1 && !$l): ?>
                    <?php $l = true; ?>
                        <li class="disabled"><a href="#"><span>...</span></a></li>
                    
                    <?php elseif($page > $cp+2 && $page < $t && !$r): ?>
                        <?php $r = true; ?>
                        <li class="disabled"><a href="#"><span>...</span></a></li>
                    
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li class=" tran3s"><a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">&raquo;</a></li>
        <?php else: ?>
            <li class="disabled"><a href="#"><span>&raquo;</span></a></li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
