

$(function(){
    // Contact Form Validation
    if ($('#contact-form').length) {
        $("#contact-form").validate({
            submitHandler: function(form) {
                var form_btn = $(form).find('button[type="submit"]');
                var form_result_div = '#form-result';
                $(form_result_div).remove();
                form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
                var form_btn_old_msg = form_btn.html();
                form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
                $(form).ajaxSubmit({
                    dataType: 'json',
                    success: function(data) {
                        var msg = '';
                        if (data.status) {
                            $(form).find('.form-control').val('');
                            msg = "Gửi liên hệ thành công!";
                        }else if(data.errors.length){
                            msg = data.errors.join("<br />>");
                        }else{
                            msg = "lỗi không xác định";
                        }
                        form_btn.prop('disabled', false).html(form_btn_old_msg);
                        $(form_result_div).html(msg).fadeIn('slow');
                        setTimeout(function() { $(form_result_div).fadeOut('slow') }, 6000);
                    }
                });
            }
        });
    }
});
