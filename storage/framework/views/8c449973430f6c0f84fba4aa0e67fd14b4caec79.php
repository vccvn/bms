<?php $__env->startSection('content'); ?>
<section>
            <div class="container">
                <div class="about-us row">
					<div class="col-md-6 col-sm-8 about-detail">
						<h2 class="title text-left">Đôi nét về BMS</h2>
                    	<hr class="divider">
                    	<div class="range"></div>
						<p >
							BMS được ra mắt vào 2018. Là trang web hàng đầu để tìm vé xe buýt liên thành phố trực tuyến. Hệ thống đặt vé của chúng tôi cho phép du khách tìm kiếm vé xe buýt cho hơn một trăm công ty xe buýt trên khắp Việt Nam
						</p>
						<p>		
							Chúng tôi cung cấp cho khách hàng khả năng tìm kiếm nhiều lịch biểu từ nhiều mạng di động ở một nơi để họ có thể dễ dàng so sánh và quyết định điều gì phù hợp nhất với họ.</p>
					</div>
					<div class="col-md-6 col-sm-8 about-media ">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/3dbzNv-OZ0w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						
					</div>					
                </div>
            </div>
        </section>
        <section class="bg-zircon">
            <div class="container">
                <div class="testimonials ">
                    <h2 class="title"> Đánh giá</h2>
                    <hr class="divider">
                    <div class="range owl-carousel">
                    <div> 
                        <blockquote>
                            <div class="media">
                                <div class="media-left">
                                    <span class="icon icon-xs fa fa-quote-left"></span>
                                </div>
                                <div class="media-body">
                                    I haven't ever booked any ticket before BusExpress, but the site looks great as if we are booking an air ticket. Great work! I will definitely book tickets from your company from now on!
                                    <div class="testimonials-user">
                                       <div class="img-user">
                                            <img src="<?php echo e(get_theme_url('images/user1.jpg')); ?>" alt="">
                                       </div>
                                        <div class="name-user">
                                            <span>Roger Washington</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                        <div > 
                            <blockquote>
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon icon-xs fa fa-quote-left"></span>
                                    </div>
                                    <div class="media-body">
                                        I haven't ever booked any ticket before BusExpress, but the site looks great as if we are booking an air ticket. Great work! I will definitely book tickets from your company from now on!
                                        <div class="testimonials-user">
                                           <div class="img-user">
                                                <img src="<?php echo e(get_theme_url('images/user1.jpg')); ?>" alt="">
                                           </div>
                                            <div class="name-user">
                                                <span>Roger Washington</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                        <div > 
                            <blockquote>
                                <div class="media">
                                    <div class="media-left">
                                        <span class="icon icon-xs fa fa-quote-left"></span>
                                    </div>
                                    <div class="media-body">
                                        Thank you very much for support. Keep going like this and I wish you people to be the No.1 Online Bus Ticket provider in our country. You are really doing a good job.
                                        <div class="testimonials-user">
                                            <div class="img-user">
                                                 <img src="<?php echo e(get_theme_url('images/user1.jpg')); ?>" alt="">
                                            </div>
                                            <div class="name-user">
                                                <span>Roger Washington</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                      </div>
                    </div>
                </div>
        </section>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>