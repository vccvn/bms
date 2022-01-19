Cube.help_center = {
    url: "",
    isShow: false,
    showHelpPopup: function() {
        if (this.isShow) return this.show();
        this.isShow = false;

        var content = '<div class="help-form-area">' +
            '<form id="contact-form" name="contact_form" class="default-form tt-help-form" action="" method="get">' +
            '<div class="row clearfix">' +

            '<div class="col-md-12 col-sm-12 col-xs-12">' +
            '<div class="form-group style-two">' +
            '<h3 class="title"> Hãy để lại thông tin của bạn để chúng tôi có thể hỗ trợ bạn tốt hơn</h3>' +
            '</div>' +
            '</div>' +

            '<div class="col-md-12 col-sm-12 col-xs-12">' +
            '<div class="form-group style-two">' +
            '<input type="text" name="name" class="form-control required help-name" placeholder="Họ tên" required="">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6 col-sm-6 col-xs-12">' +
            '<div class="form-group style-two">' +
            '<input type="text" name="phone" class="form-control help-phone" value="" placeholder="Số điện thoại" required="">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6 col-sm-6 col-xs-12">' +
            '<div class="form-group style-two">' +
            '<input type="email" name="email" class="form-control help-email" value="" placeholder="Email (nếu có)">' +
            '</div>' +
            '</div>' +

            '</div>' +
            '</form>' +

            '</div>' +

            '<div class="help-message"></div>';
        custom_modal({
            title: "Hỗ trợ",
            content: content,
            buttons: [
                { type: "button", className: "btn btn-primary btn-submit-client-info", text: "Nhận hỗ trợ" }
            ]
        });
    },
    show: function() {
        $('.modal .help-form-area').show();
        $('.modal .help-message').hide();
        $('.modal .btn-submit-client-info').show("Nhận hỗ trợ");
    },
    message: function(msg) {
        $('.modal .help-form-area').hide();
        $('.modal .help-message').html(msg);
        $('.modal .help-message').show();
        $('.modal .btn-submit-client-info').show("Ok");

    }
};

$(function() {
    $(document).on('click', '.modal .btn-submit-client-info', function() {
        var name = $('.tt-help-form .help-name').val();
        var phone = $('.tt-help-form .help-phone').val();
        var email = $('.tt-help-form .help-email').val();
        if (!name || !phone) {
            return alert("Vui lòng nhập dủ Họ tên và số điện thoại của bạn");
        }
        $.post(Cube.help_center.url, { name: name, phone: phone, email: email }, function(rs) {
            if (rs.status) {
                return modal_alert(rs.message);
            }
            return alert(msg);
        });
    });
});