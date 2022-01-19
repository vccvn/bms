
<div class="modal fade" id="modal-role-users" tabindex="-1" role="dialog" aria-labelledby="detail-role-user-name" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<i class="fa fa-key"></i> <span id="modal-role-user-name"></span>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a data-toggle="tab" href="#detail-role-user" class="btn-role-tab nav-link active" role="tab" data-tab="inrole">Được cấp quyền</a>
					</li>
					<li class="nav-item">
						<a data-toggle="tab" href="#detail-role-add-user" class="btn-role-tab nav-link " role="tab" data-tab="notinrole">Cấp quyền</a>
					</li>
				</ul>

				<div class="tab-content">
					<div id="detail-role-user" class="tab-pane fade in active show" aria-expanded="true">
						
						<div class="modal-list">
							<div class="list-header">
								<div class="row">
									<div class="col-12 col-sm-7"><h4>Được cấp quyền</h4></div>
									<div class="col-12 col-sm-5">
										<form  id="user-in-role-search" class="user-role-search">
											<div class="input-group">
												<input type="search" name="search" placeholder="Tìm kiếm..." class="form-control search-inp">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div><!-- /input-group -->
											
										</form>
									</div>

								</div>
								<div class="list-title row">
									<div class="col-2 col-sm-2 col-md-1">
										<label class="d-block">
											<input type="checkbox" name="check_all" class="check-all checkbox" id="">
											<span></span>
										</label>
									</div>
									<div class="col-2 col-sm-2 col-md-1">
										<strong>ID</strong>
									</div>
									<div class="col-4 col-sm-4 col-md-5">
										<strong>Họ tên</strong>
									</div>
									<div class="col-4 col-sm-4 col-md-5">
										<strong>Email</strong>
									</div>
								</div>

							</div>
							<div class="list-body">
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger btn-remove-role-user">Xóa</button>
								<button type="button" class="btn btn-primary btn-seemore-role-user">Xem thêm</button>
								<button type="button" class="btn btn-warning btn-refresh-role-user">Làm mới</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
								{{--  <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>  --}}
							</div>
						</div>
						
					</div>
					<div id="detail-role-add-user" class="tab-pane fade" aria-expanded="false">
						<div class="modal-list">
							<div class="list-header">
								<div class="row">
									<div class="col-12 col-sm-7 col-md-7"><h4>Cấp quyền</h4></div>
									<div class="col-12 col-sm-5 col-md-5">
										<form  id="user-not-in-role-search" class="user-role-search">
											<div class="input-group">
												<input type="search" name="search" placeholder="Tìm kiếm..." class="form-control search-inp">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div><!-- /input-group -->
											
										</form>
									</div>

								</div>
								<div class="list-title row">
									<div class="col-2 col-sm-2 col-md-1">
										<label class="d-block">
                                            <input type="checkbox" name="check_all" class="check-all checkbox" id="">
                                            <span></span>
                                        </label>
									</div>
									<div class="col-2 col-sm-2 col-md-1">
										<strong>ID</strong>
									</div>
									<div class="col-4 col-sm-4 col-md-5">
										<strong>Họ tên</strong>
									</div>
									<div class="col-4 col-sm-4 col-md-5">
										<strong>Email</strong>
									</div>
								</div>

							</div>
							<div class="list-body">
								//
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary btn-add-role-user">Thêm</button>
								<button type="button" class="btn btn-primary btn-seemore-role-user">Xem thêm</button>
								<button type="button" class="btn btn-warning btn-refresh-role-user">Làm mới</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							</div>
						</div>
					</div>
					
				</div>
				<div class="loading">
					<div class="cube-img-loading">
						<img src="{{asset('images/static/loading.gif')}}" alt="">
					</div>
				</div>
			</div>

		</div>
	</div>
</div>












<div class="modal fade" id="modal-role-modules" tabindex="-1" role="dialog" aria-labelledby="detail-role-module-name" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<i class="fa fa-key"></i> <span id="modal-role-module-name"></span>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a data-toggle="tab" href="#detail-role-module" class="btn-role-tab nav-link active" role="tab" data-tab="required">Đã yêu cầu quyền</a>
					</li>
					<li class="nav-item">
						<a data-toggle="tab" href="#detail-role-add-module" class="btn-role-tab nav-link" role="tab" data-tab="notrequired">Thêm yêu cầu quyền</a>
					</li>
				</ul>


				<div class="tab-content">
					<div id="detail-role-module" class="tab-pane fade in active show" aria-expanded="true">
						
						<div class="modal-list">
							<div class="list-header">
								<div class="row">
									<div class="col-12 col-sm-7"><h4>Đã yêu cầu quyền</h4></div>
									<div class="col-12 col-sm-5">
										<form  id="module-required-role-search" class="module-role-search">
											<div class="input-group">
												<input type="search" name="search" placeholder="Tìm kiếm..." class="form-control search-inp">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div><!-- /input-group -->
											
										</form>
									</div>

								</div>
								<div class="list-title row">
									<div class="col-2 col-sm-2 col-md-1">
										<label class="d-block">
                                            <input type="checkbox" name="check_all" class="check-all checkbox" id="">
                                            <span></span>
                                        </label>
									</div>
									<div class="col-2 col-sm-2 col-md-1">
										<strong>ID</strong>
									</div>
									<div class="col-8 col-sm-8 col-md-10">
										<strong>Tên Module</strong>
									</div>
								</div>

							</div>
							<div class="list-body">
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger btn-remove-role-module">Xóa</button>
								<button type="button" class="btn btn-primary btn-seemore-role-module">Xem thêm</button>
								<button type="button" class="btn btn-warning btn-refresh-role-module">Làm mới</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							</div>
						</div>
						
					</div>
					<div id="detail-role-add-module" class="tab-pane fade" aria-expanded="false">
						<div class="modal-list">
							<div class="list-header">
								<div class="row">
									<div class="col-12 col-sm-7 col-md-7"><h4>Danh sách module</h4></div>
									<div class="col-12 col-sm-5 col-md-5">
										<form  id="module-not-required-role-search" class="module-role-search">
											<div class="input-group">
												<input type="search" name="search" placeholder="Tìm kiếm..." class="form-control search-inp">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div><!-- /input-group -->
											
										</form>
									</div>

								</div>
								<div class="list-title row">
									<div class="col-2 col-sm-2 col-md-1">
										<label class="d-block">
                                            <input type="checkbox" name="check_all" class="check-all checkbox" id="">
                                            <span></span>
                                        </label>
									</div>
									<div class="col-2 col-sm-2 col-md-1">
										<strong>ID</strong>
									</div>
									<div class="col-8 col-sm-8 col-md-10">
										<strong>Tên Module</strong>
									</div>
								</div>

							</div>
							<div class="list-body">
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary btn-add-role-module">Thêm</button>
								<button type="button" class="btn btn-primary btn-seemore-role-module">Xem thêm</button>
								<button type="button" class="btn btn-warning btn-refresh-role-module">Làm mới</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							</div>
						</div>
					</div>
					
				</div>
				<div class="loading">
					<div class="cube-img-loading">
						<img src="{{asset('images/static/loading.gif')}}" alt="">
					</div>
				</div>
			</div>

		</div>
	</div>
</div>