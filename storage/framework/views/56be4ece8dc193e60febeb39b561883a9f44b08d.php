<div class="modal fade" id="modal-add-web-option" tabindex="-1" role="dialog" aria-labelledby="detail-web-option" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">

		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<i class="fa fa-wrench"></i> <span id="detail-web-option">Thêm thuộc tính mới</span>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="add-web-option-item-form">
					<div class="form-group row" id="form-group-item-name">
						<label for="item-name" class="col-sm-4 form-control-label" id="label-for-name">Tên thuộc tính</label>
						<div class="col-sm-8">
							<input type="text" name="name" id="item-name" class="form-control" placeholder="nhập tên thuộc tính ví dụ email" />
						</div>
					</div>

					<div class="form-group row" id="form-group-item-type">
						<label for="item-type" class="col-sm-4 form-control-label" id="label-for-type">Kiểu dữ liệu</label>
						<div class="col-sm-8">
							<select name="type" id="item-type" class="form-control">
								<option value="text">Chuỗi</option>
								<option value="textarea">Văn bản</option>
								<option value="number">Số</option>
								<option value="email">Email</option>
								<option value="file">File ảnh</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="form-group-item-comment">
						<label for="item-comment" class="col-sm-4 form-control-label" id="label-for-comment">Chú thích <br> (tùy chọn)</label>
						<div class="col-sm-8">
							<textarea name="comment" id="item-comment" class="form-control" placeholder="nhập Chú thích nếu cần" ></textarea>
						</div>
					</div>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary">Thêm</button>
                		<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
					</div>
				</form>
				<div class="form-alert" style="display: none;">
					<p class="message mb-3 text-center"></p>
					<div class="buttons text-center">
						<button type="button" class="btn btn-primary btn-ok">OK</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

