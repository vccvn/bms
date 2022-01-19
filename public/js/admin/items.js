/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.items = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},
    init_list: ["urls", "templates"],
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
    delete: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length + " khoản mục này" : "<strong>" + $('#item-name-' + ids[0]).data('name') + "</strong>") + "?";
        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(this.urls.delete_url, "POST", { ids: this.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {

                            for (var i = 0; i < rs.remove_list.length; i++) {
                                var rmid = rs.remove_list[i];
                                $('#item-' + rmid).hide(400, function() {
                                    $(this).remove();
                                });
                            }

                        }
                    } else {
                        modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                });
            }
        }.bind(this));
    }
};

$(function() {
    if (typeof window.itemsInit == 'function') {
        window.itemsInit();
        window.itemsInit = null;
    }

    // delete item
    $(document).on('click', '.btn-delete-item', function() {
        var id = $(this).data('id');
        Cube.items.delete([id]);
        return false;
    });

    // delete all item
    $(document).on('click', '.btn-delete-all-item', function() {
        var list = $('.list-body.list-item input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn mục nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.items.delete(ids);
        return false;
    });

});