

<?php if($tags): ?>
                                <div class="pull-left tags"><strong>Thẻ :</strong> 
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('client.search',['s'=>$tag->keywords])); ?>"><?php echo e($tag->keywords); ?> </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
<?php endif; ?>