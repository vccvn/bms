<?php if($welcome_page): ?>
        
        <section class="default-section black-bg">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <!--video-box-->
                        <div class="video-image-box mar-bottom-40">
                            <figure class="image">
                                <img src="<?php echo e($welcome_page->getFeatureImage()); ?>" alt="">
                                <a href="https://www.youtube.com/watch?v=nfP5N9Yc72A&amp;t=28s" class="overlay-link lightbox-image video-fancybox"><span class="icon flaticon-play-button"></span></a>
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="feature-block-two">
                            <h2><?php echo e($welcome_page->title); ?></h2>
                            <h4><?php echo e($welcome_page->description); ?></h4>
                            <div class="text">
                                <?php echo $welcome_page->content; ?>

                            </div>
                            <div class="link"><a href="<?php echo e($about_page? $about_page->getViewUrl():'#'); ?>" class="theme-btn btn-style-two">Xem thêm</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php endif; ?>