
                                    <div class="input-hidden-tags-group d-none" style="diplay:none">
                                        <?php if($o = old('tags')): ?>
                                            <?php $__currentLoopData = $o; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <input type="hidden" name="tags[]" id="tag-hidden-<?php echo e($tid); ?>" class="input-tag-hidden" value="<?php echo e($tid); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php elseif($model->tagLinks): ?>
                                            <?php $__currentLoopData = $model->tagLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <input type="hidden" name="tags[]" id="tag-hidden-<?php echo e($tag->tag_id); ?>" class="input-tag-hidden" value="<?php echo e($tag->tag_id); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tag-list">
                                        <?php
                                            $tags = [];
                                            if($old = old('tags')){
                                                $tags = get_tag_list(['id'=>$old]);
                                            }
                                            elseif ($model->tagLinks) {
                                                $tags = $model->tagLinks;
                                            }
                                            if($tags){
                                                $item = $tag_templates['link_item'];
                                                $list = $tag_templates['link_list'];
                                                $total = count($tags);
                                                $items = '';
                                                foreach($tags as $t){
                                                    if($t->tag_id) $tag = $t->tag;
                                                    else $tag = $t;
                                                    $items.=str_eval($item,['id'=>$tag->id,'keywords'=>$tag->keywords]);
                                                }
                                                $taglist = str_eval($list,['items'=>$items,'total'=>$total]);
                                                echo $taglist;
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group tag-group with-live-search" data-search="#input-tag-link">
                                        <div class="input-group" >
                                            <input type="text" name="tag" id="input-tag-link" class="form-control input-search-tag" placeholder="Nhập từ khóa...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-searct-tag"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                        <div class="live-search">
                                            <div class="result d-none">

                                            </div>
                                            <div class="message d-none">
                                                <div id="livw-search-message-text" class="message-text text-center text-info"></div>
                                            </div>
                                            <div class="actions action-menu d-none">
                                                <a href="#" class="btn-action action-item add-tag btn-add-new-tags btn btn-primary btn-block">Thêm "<span>tag</span>"</a>
                                            </div>
                                        </div>
                                    </div>

