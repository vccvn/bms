<style>
    .comments-section{
        margin: 50px auto;
    }
    .facebook-comments{
        margin-top: 10px;
        margin-bottom: 10px;
        position: relative;
    }

</style>


    
                       <section class="comments-section">
                            <div class="comments-wrapper">
                                <ul class="post-filter text-left list-inline diferent-choose">
                                    <li class="active" data-filter=".web-comment">
                                        <span><?php echo e($siteinfo->site_name); ?></span>
                                    </li>
                                    <li data-filter=".facebook-comment">
                                            <span>Facebook</span>
                                        </li>
                                        
                                </ul>
                                <div class="bs4-row clearfix masonary-layout filter-layout">
                                    <div class="facebook-comment col-12">
                                        
                                        <?php
                                        $u = isset($url)?$url:(isset($link)?$link:'');
                                        $w = isset($width)?$width:'100%';
                                        $n = isset($show)?$show:'10';
                                        ?>
                                        <div class="facebook-comments position-relative">
                                            <div 
                                                class="fb-comments" 
                                                data-href="<?php echo e($u); ?>" 
                                                data-width="<?php echo e($w); ?>" 
                                                data-numposts="<?php echo e($n); ?>"
                                            ></div>
                                        </div>
                                    </div>
                                        
                                    <!--Default Portfolio Item-->
                                    <div class="web-comment col-12 col-sm-12">
                                        
                                        <div class="comments-area" id="comments">
                                            <?php if($comments): ?>
                                                <div class="group-title"><h2><?php echo e(count($comments)); ?> bình luận</h2></div>
                                                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php 
                                                    $user = $c->user(); 
                                                    $replies = $c->replies;
                                                    ?>
                
                                                    <!--Comment Box-->
                                                    <div class="comment-box">
                                                        <div class="comment">
                                                            <div class="author-thumb"><img src="<?php echo e($user->getAvatar()); ?>" alt="<?php echo e($user->name); ?>"></div>
                                                            <div class="comment-inner">
                                                                <div class="comment-info clearfix"><strong><?php echo e($user->name); ?></strong><br><div class="comment-time"><?php echo e($c->dateFormat('d-m-Y')); ?></div></div>
                                                                <div class="text"><?php echo nl2br($c->content); ?></div>
                                                                <a class="comment-reply" data-id="<?php echo e($c->id); ?>" href="#">Trả lời</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($replies): ?>
                                                        <?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php 
                                                            $u = $rep->user(); 
                                                            $reps = $rep->replies;
                                                            ?>
                                                            <!--Reply Comment Box-->
                                                            <div class="comment-box reply-comment">
                                                                <div class="comment">
                                                                    <div class="author-thumb"><img src="<?php echo e($u->getAvatar()); ?>" alt="<?php echo e($u->name); ?>"></div>
                                                                    <div class="comment-inner">
                                                                        <div class="comment-info clearfix"><strong><?php echo e($u->name); ?></strong><br><div class="comment-time"><?php echo e($rep->dateFormat('d-m-Y')); ?></div></div>
                                                                        <div class="text"><?php echo nl2br($rep->content); ?></div>
                                                                        <a class="comment-reply" data-id="<?php echo e($rep->id); ?>" href="#">Trả lời</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                
                                                            <?php if($reps): ?>
                                                                <?php $__currentLoopData = $reps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $re): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php 
                                                                    $usr = $re->user(); 
                                                                    ?>
                                                                    <!--Reply Comment Box-->
                                                                    <div class="comment-box reply-comment">
                                                                        <div class="comment">
                                                                            <div class="author-thumb"><img src="<?php echo e($usr->getAvatar()); ?>" alt="<?php echo e($usr->name); ?>"></div>
                                                                            <div class="comment-inner">
                                                                                <div class="comment-info clearfix"><strong><?php echo e($usr->name); ?></strong><br><div class="comment-time"><?php echo e($re->dateFormat('d-m-Y')); ?></div></div>
                                                                                <div class="text"><?php echo nl2br($re->content); ?></div>
                                                                                <a class="comment-reply" data-id="<?php echo e($re->id); ?>" href="#">Trả lời</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="comment-form wow fadeInUp" id="leave-comment-form" data-wow-delay="200ms" data-wow-duration="1500ms">
                                            <div class="group-title"><h2>Để lại ý kiến của bạn</h2></div>
                                            <!--Comment Form-->
                                            <form method="post" action="<?php echo e(route('client.comment.save')); ?>" novalidate>
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="object" value="<?php echo e($object); ?>" class="cmt-input">
                                                <input type="hidden" name="object_id" value="<?php echo e($object_id); ?>" class="cmt-input">
                                                <div class="row clearfix">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input type="text" name="name" placeholder="Họ và Tên" class="cmt-input">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                        <input type="email" name="email" placeholder="Email" class="cmt-input">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                        <textarea name="content" placeholder="Nội dung" class="cmt-input"></textarea>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                                        <button class="theme-btn btn-style-one" type="submit" name="submit-form">Gửi</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </section>