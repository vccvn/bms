/**
 * 
 * @type {Object}
 */
Cube.trips = {
    currentID: 0,
    listID: [],
    urls: {},
    templates:{},
    init_list: ["urls", "templates"],
    status_list: { "100": "Hoàn thành","1": "Chờ xuất bến", "0": "Chờ", "-1":"Bị Hủy" },
    status_color_types: {"0": "secondary", "100": "success","1": "warning", "-1":"danger"},
    init: function(args) {
        if (!args || typeof args == 'undefined') return;
        for (var key of this.init_list) {
            if (typeof args[key] != 'undefined') {
                var d = args[key];
                var t = Cube.getType(d);

                var t2 = (typeof(this[key]) != 'undefined') ? Cube.getType(this[key]) : "string";
                if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                    for (var k in d) {
                        var v = d[k];
                        this[key][k] = v;
                    }
                } else {
                    this[key] = d;
                }
            }
        }
    },
    getBtnColor: function(status) {
        if (status) {
            if (typeof this.status_color_types[status] != 'undefined') {
                return this.status_color_types[status];
            }
        }
        return 'secondary';
    },
    changeStatus: function(id, status) {
        Cube.ajax(this.urls.change_status_url, "POST", { id: id, status: status }, function(rs) {
            if (rs.status) {
                var trip = rs.trip;
                if (trip) {
                    var $btn = $('#item-' + trip.id + ' .status-text');
                    $btn.html(this.status_list[status]);
                    $btn.removeClass('text-primary')
                        .removeClass('text-secondary')
                        .removeClass('text-danger')
                        .removeClass('text-warning')
                        .addClass('text-' + this.getBtnColor(status));
                    $('#item-' + trip.id + ' .trip-status-select .status-select a').removeClass('active');
                    $('#item-' + trip.id + '-' + status).addClass('active');
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },

    update: function(id) {
        custom_modal({
            title: "Cập nhật thông tin chuyến",
            content: this.templates.loading
        });
        $('#forn-animate-loading').removeClass('d-none');

        this.currentID = id;
        Cube.ajax(this.urls.get_form_url, "POST", { id: id }, function(rs) {
            if (rs.status) {
                var form = rs.form;
                custom_modal({
                    title: "Cập nhật thông tin chuyến",
                    content: Cube.str.eval(this.templates.form + this.templates.message + this.templates.loading, { 
                        form: form, message: "thao tác thành công" 
                    }),
                    buttons: this.templates.buttons
                });
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },
    saveUpdate: function () {
        if($('#update-item-form .trip-input').length){
            try{
                var data = {};
                $('#update-item-form .trip-input').each(function(i,e) {
                    data[$(e).attr('name')] = $(e).val();
                });
                $('#update-item-form, #update-item-message, .btn-back-to-form, .btn-submit-update').addClass('d-none');
                $('#forn-animate-loading').removeClass('d-none');

                Cube.ajax(this.urls.save_url, "POST", data, function(rs){
                    if (rs.status) {
                        modal_alert("Đã cập nhật thông tin chuyến thành công",function(){
                            modal_hide_callback = function(){
                                modal_confirm("Bạn có muốn tải lại trang không", function(s){
                                    if(s){
                                        showLoading();
                                        top.location.reload();
                                    }
                                })
                            };
                        });
                    } else {
                        $('#update-item-form, #forn-animate-loading, .btn-submit-update').addClass('d-none');
                        $('#update-item-message, .btn-back-to-form').removeClass('d-none');
                        $('#update-item-message-text').html(rs.errors.join('<br />'));
                        $('#update-item-message-text').removeClass(['alert-success', 'alert-primary', 'alert-warning', 'alert-danger']).addClass('alert-warning');
                    }
                }.bind(this), function(e){
                    $('#update-item-form, #forn-animate-loading, .btn-submit-update').addClass('d-none');
                    $('#update-item-message, .btn-back-to-form').removeClass('d-none');
                    $('#update-item-message-text').html("Lỗi không xác định");
                    $('#update-item-message-text').removeClass(['alert-success', 'alert-primary', 'alert-warning', 'alert-danger']).addClass('alert-warning');

                })
            }catch(e){
                // something here
            }
            
        }
    },
    showForm: function() {
        $('#update-item-message, .btn-back-to-form, #forn-animate-loading').removeClass('d-none').addClass('d-none');
        $('#update-item-form, .btn-submit-update').removeClass('d-none');

    }
};

$(function() {
    if (typeof window.tripsInit == 'function') {
        window.tripsInit();
        window.tripsInit = null;
    }

    $(document).on('click', '.trip-status-select .status-select a', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        Cube.trips.changeStatus(id, status);
    });

    // xem chi tiet trip


    

    //update

    $('.btn-update-item').click(function() {
        let id = $(this).data('id');
        Cube.trips.update(id);
        return false;
    });

    // save update
    $(document).on('click', '.btn-submit-update', function() {
        Cube.trips.saveUpdate();
    });

    
    $(document).on('click', '.btn-back-to-form', function() {
        Cube.tags.showForm();
    });


});