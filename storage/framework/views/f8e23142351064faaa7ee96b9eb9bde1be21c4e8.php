<?php $__env->startSection('title','Liên hệ'); ?>

<?php $__env->startSection('content'); ?>

        <section>
                <div class="container">
                    <div class="contact row">
                        <div class="col-lg-8 col-md-10 col-sm-10 col-10 about-detail mx-auto">
                            <h2 class="title text-left">Liên hệ</h2>
                            <hr class="divider">
                            <div class="range"></div>
                            <p >
                                Bạn có thể liên lạc với chúng tôi với bất kỳ cách nào thuận tiện cho bạn. Chúng tôi luôn sẫn sàng 24/7. Bạn cũng có thể sử dụng mẫu liên hệ dưới đây.</p>
                            <p>
                                Chúng tôi rất sẫn lóng trả lời câu hỏi của bạn 
                            </p>
                            <form id="contact-form" name="contact_form" class="contact-form default-form" action="<?php echo e(route('client.contact.ajax-send')); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="contact-group">
                                            <label for="name" class="form-control-label">Họ và tên</label>
                                            <input type="text" name="name" id="name" class="form-control" value="" placeholder="Họ tên (bắt buộc)" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="contact-group">
                                            <label for="email" class="form-control-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control required email" value="" placeholder="Email (bắt buộc)" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="contact-group">
                                            <label for="phone_number" class="form-control-label">Số diên thoại</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="" placeholder="Số điện thoại (tùy chọn)">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="contact-group">
                                            <label for="subject" class="form-control-label">Chủ đề</label>
                                            <input type="text" name="subject" id="subject" class="form-control" value="" placeholder="Chủ đề (tùy chọn)">
                                        </div>
                                    </div>  
                                    <div class="col-md-12 col-sm-12">
                                        <div class="contact-group">
                                            <label for="message" class="form-control-label">Nội dung</label>
                                            <textarea name="content" id="message" class="form-control required" placeholder="Nội dung liên hệ (bắt buộc)"></textarea>
                                        </div>
                                    </div>                                                
                                </div>
                                <div class="contact-section-btn ">
                                    <div class="contact-group text-center">
                                        <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                        <button class="btn" type="submit" data-loading-text="Vui lòng chờ giây lát...">Gửi</button>
                                    </div>
                                </div> 
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-10 col-sm-10 col-10 mx-auto">
                            <div class="contact-list">
                                
                                <div class="contact-item">
                                    <h5>Điện thoại</h5>
                                    <div class="col-md-12 text-subline"></div>
                                    <div class="detail-contact">
                                        <a href="tel:<?php echo e($pn = $siteinfo->phone_number('0945786960')); ?>" class="">
                                            <span class="badge badge-pill badge-primary icon d-inline-flex">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                            <span><?php echo e($pn); ?></span>
                                        </a>
                                    </div>    
                                </div>
                                <div class="contact-item">
                                    <h5>Email</h5>
                                    <div class="col-md-12 text-subline"></div>
                                    <div class="detail-contact">
                                        <a href="mailto:<?php echo e($em = $siteinfo->email('doanln16@gmail.com')); ?>">
                                            <span class="badge badge-pill badge-primary icon d-inline-flex">
                                                <i class="fa fa-mail-bulk"></i>
                                            </span>
                                            <span><?php echo e($em); ?></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <h5>Địa chỉ</h5>
                                    <div class="col-md-12 text-subline"></div>
                                    <div class="detail-contact">
                                        <a href="<?php echo e($siteinfo->map_url('#')); ?>" class="">
                                            <span class="badge badge-pill badge-primary icon d-inline-flex">
                                                <i class="fa fa-map"></i>
                                            </span>
                                            <span><?php echo e($siteinfo->office('Hàm Nghi, Mỹ Đình, Hà Nội')); ?>i</span>
                                            
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>  
                    </div>
                </div>
            </section>
<?php echo $__embed->google_map; ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'single', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>