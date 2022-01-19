// quan lis user
/**
 * doi tuong quan li user
 * @type {Object}
 */
Cube.orders = {
    currentID: 0,
    listID: [],
    urls: {},
    status_list: { "600": "Đã hoàn thành", "300": "đang xử lý", "0": "Mới yêu cầu", "-1": "Bị hũy" },
    status_color_types: {},
    templates: {},
    labels: {},

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

        if (typeof args.status_color_types != 'undefined') {
            var o = args.status_color_types;
            var t = Cube.getType(o);
            if (t == 'array' || t == 'object') {
                for (var key in o) {
                    var val = o[key];
                    this.status_color_types[key] = val;
                }
            }
        }

        if (typeof args.labels != 'undefined') {
            var o = args.labels;
            var t = Cube.getType(o);
            if (t == 'array' || t == 'object') {
                for (var key in o) {
                    var val = o[key];
                    this.labels[key] = val;
                }
            }
        }

        if (typeof args.templates != 'undefined') {
            var t2 = Cube.getType(args.templates);
            if (t2 == 'array' || t2 == 'object') {
                for (var key in args.templates) {
                    var val = args.templates[key];
                    this.templates[key] = val;
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
    delete: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn xóa " + ((ids.length > 1) ? ids.length : "") + " đơn hàng này?";

        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(Cube.orders.urls.delete_url, "POST", { ids: Cube.orders.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#order-item-' + rs.remove_list[i]).hide(300, function() {
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
    changeStatus: function(id, status) {
        Cube.ajax(this.urls.change_status_url, "POST", { id: id, status: status }, function(rs) {
            if (rs.status) {
                var order = rs.order;
                if (order) {
                    var $btn = $('#order-' + order.id + ' .status-text');
                    $btn.html(Cube.orders.status_list[status]);
                    $btn.removeClass('text-primary')
                        .removeClass('text-secondary')
                        .removeClass('text-danger')
                        .removeClass('text-warning')
                        .addClass('text-' + this.getBtnColor(status));
                    $('#order-' + order.id + ' .order-status-select .status-select a').removeClass('active');
                    $('#order-' + order.id + '-' + status).addClass('active');
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },

    viewDetail: function(id) {
        Cube.ajax(this.urls.view_url, 'GET', { id: id }, function(rs) {
            if (rs.status) {
                var o = rs.order;
                cl(o);
                var tpl = '';
                for (var label in this.labels) {
                    var text = this.labels[label];
                    var detail = o[label];
                    if (label == 'products') {
                        if (o.products.length) {
                            var items = '';
                            for (var item of o.products) {
                                items += Cube.str.eval(this.templates.product_item, item);
                            }
                            detail = Cube.str.eval(this.templates.product_list, { items: items });
                        } else {
                            detail = '';
                        }
                    } else if (label == 'status') {
                        detail = '<select name="order-status" id="input-order-status" class="form-control" style="max-width:220px">';
                        for (var stt in this.status_list) {
                            var txt = this.status_list[stt];
                            detail += '<option value="' + stt + '"' + (stt == o.status ? ' selected' : '') + '>' + txt + '</option>';
                        }
                        detail += '</select>';
                    } else if (label == 'notes' && detail == null) {
                        detail = 'Không có ghi chú';
                    }
                    var d = { label: text, detail: detail };
                    tpl += Cube.str.eval(this.templates.row, d);
                }
                custom_modal({
                    title: "Chi tiết đơn hàng #" + id,
                    content: tpl,
                    buttons: [
                        { type: "button", className: "btn btn-primary btn-save-order-detail", text: "Lưu" }
                    ],
                    size: 'lg'
                });
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    }
};

$(function() {
    if (typeof window.ordersInit == 'function') {
        window.ordersInit();
        window.ordersInit = null;
    }

    // delete order
    $(document).on('click', '.btn-delete-order', function() {
        var id = $(this).data('id');
        Cube.orders.delete([id]);
        return false;
    });

    // delete all order
    $(document).on('click', '.btn-delete-all-order', function() {
        var list = $('.list-body.list-order input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Bài viết nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.orders.delete(ids);
        return false;
    });

    $(document).on('click', '.order-status-select .status-select a', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        Cube.orders.changeStatus(id, status);
    });

    // xem chi tiet order

    $(document).on('click', '.view-order-detail', function() {
        var id = $(this).data('id');
        Cube.orders.currentID = id;
        Cube.orders.viewDetail(id);
        return false;
    });

    $(document).on('click', '.btn-save-order-detail', function() {
        var status = $('#input-order-status').val();
        var id = Cube.orders.currentID;
        Cube.orders.changeStatus(id, status);
        hideModal();
        return false;
    });

});