// quan lis slider
/**
 * doi tuong quan li slider
 * @type {Object}
 */
Cube.sliders = {
    currentID: 0,
    listID: [],
    urls: {},
    init: function(args) {
        if (typeof args.urls != 'undefined') {
            var t = Cube.getType(args.urls);
            if (t == 'array' || t == 'object') {
                for (var key in args.urls) {
                    var val = args.urls[key];
                    this.urls[key] = val;
                }
            }
        }
    },
    delete: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length + " slider này" : "slider <strong>" + $('#slider-name-' + ids[0]).text() + "</strong>") + "?";
        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(Cube.sliders.urls.delete_url, "POST", { ids: Cube.sliders.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {

                            for (var i = 0; i < rs.remove_list.length; i++) {
                                var rmid = rs.remove_list[i];
                                $('#slider-' + rmid).hide(400, function() {
                                    $(this).remove();
                                });
                            }

                        }
                    } else {
                        modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                });
            }
        });
    },
    changeItemPriority: function(id, priority) {
        Cube.ajax(Cube.sliders.urls.change_item_priority_url, "POST", { id: id, priority: priority }, function(rs) {
            if (rs.status) {
                if (rs.data && rs.data.length) {
                    for (var i = 0; i < rs.data.length; i++) {
                        var item_id = rs.data[i].id;
                        var item_priority = rs.data[i].priority;
                        $('#slider-item-' + item_id + ' .slider-item-priority-select button.dropdown-toggle').html(item_priority);
                    }
                    modal_confirm("Đã thay đổi vị trí các item thành công <br> Bạn có muốn tải lại trang không?", function(rs) {
                        if (rs) {
                            top.location.reload();
                        }
                    });
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    changeSliderPriority: function(id, priority) {
        Cube.ajax(Cube.sliders.urls.change_priority_url, "POST", { id: id, priority: priority }, function(rs) {
            if (rs.status) {
                if (rs.data && rs.data.length) {
                    for (var i = 0; i < rs.data.length; i++) {
                        var item_id = rs.data[i].id;
                        var item_priority = rs.data[i].priority;
                        $('#slider-' + item_id + ' .slider-priority-select button.dropdown-toggle').html(item_priority);
                    }

                    modal_confirm("Đã thay đổi vị trí các slider thành công <br> Bạn có muốn tải lại trang không?", function(rs) {
                        if (rs) {
                            top.location.reload();
                        }
                    });
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    checkSliderCrop: function() {
        var t = $('#form-group-crop input[type="checkbox"]').is(':checked');
        if (t) {
            $('#form-group-size').removeClass('d-none');
        } else {
            $('#form-group-size').removeClass('d-none').addClass('d-none');
        }
    }
};


$(function() {
    if (typeof window.slidersInit == 'function') {
        window.slidersInit();
        window.slidersInit = null;
    }

    // delete slider
    $(document).on('click', '.btn-delete-slider', function() {
        var id = $(this).data('id');
        Cube.sliders.delete([id]);
        return false;
    });

    // delete all slider
    $(document).on('click', '.btn-delete-all-slider', function() {
        var list = $('.list-body.list-slider input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn slider nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.sliders.delete(ids);
        return false;
    });

    $(document).on('click', '.slider-item-priority-select .priority-select a', function() {
        var id = $(this).data('id');
        var priority = $(this).data('priority');
        Cube.sliders.changeItemPriority(id, priority);
    });

    $(document).on('click', '.slider-priority-select .priority-select a', function() {
        var id = $(this).data('id');
        var priority = $(this).data('priority');
        Cube.sliders.changeSliderPriority(id, priority);
    });



    if ($('#slider-form').length) {
        Cube.sliders.checkSliderCrop();
        $('#form-group-crop input[type="checkbox"]').click(function() {
            Cube.sliders.checkSliderCrop();
        });
        $('#form-group-crop input[type="checkbox"]').change(function() {
            Cube.sliders.checkSliderCrop();
        });
    }

});