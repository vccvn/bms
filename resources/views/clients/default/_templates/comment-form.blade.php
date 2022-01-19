

                        <div class="comment-form wow fadeInUp" id="leave-comment-form" data-wow-delay="200ms" data-wow-duration="1500ms">
							<div class="group-title"><h2>Đễ lại ý kiến của bạn</h2></div>
                        	<!--Comment Form-->
							<form method="post" action="{{route('client.comment.save')}}" novalidate>
								{{csrf_field()}}
								<input type="hidden" name="object" value="{{$object}}" class="cmt-input">
								<input type="hidden" name="object_id" value="{{$object_id}}" class="cmt-input">
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
