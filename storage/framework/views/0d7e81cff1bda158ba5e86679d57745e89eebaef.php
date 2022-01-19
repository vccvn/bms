<?php if($paginator->hasPages()): ?>
    <ul class="pagination">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        <?php else: ?>
            <li class="page-item"><a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">&laquo;</a></li>
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
                    <li class="page-item disabled"><span class="page-link"><?php echo e($element); ?></span></li>
                <?php elseif(!$r && !$r2 && $mp > $cp): ?>
                    <li class="page-item disabled"><span class="page-link"><?php echo e($element); ?></span></li>
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
                            <li class="page-item active"><span class="page-link"><?php echo e($page); ?></span></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php elseif($page < $cp-2 && $page > 1 && !$l): ?>
                    <?php $l = true; ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    
                    <?php elseif($page > $cp+2 && $page < $t && !$r): ?>
                        <?php $r = true; ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li class="page-item"><a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">&raquo;</a></li>
        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
