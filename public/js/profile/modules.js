Cube.modules = {
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
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " module này?", function(ans) {
            if (ans) {
                Cube.ajax(Cube.modules.urls.delete_module_url, "POST", { ids: Cube.modules.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#module-item-' + rs.remove_list[i]).hide(300, function() {
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
    checkType: function() {
        var fg = '#form-group-';
        $(fg + 'parent_id,' + fg + 'route_name,' + fg + 'route_uri,' + fg + 'route_prefix').removeClass('d-none').addClass('d-none');
        var t = $(fg + 'type select#type').val();
        if (t) {
            t2 = (t == 'default') ? 'parent_id' : t;
            $(fg + t2).removeClass('d-none');
        }
        if (t != 'route_prefix') {
            $(fg + 'parent_id').removeClass('d-none');
        }
    }
};


$(function() {
    if (typeof window.modulesInit == 'function') {
        window.modulesInit();
        window.modulesInit = null;
    }

    // module
    if ($('form#module-form').length > 0) {
        Cube.modules.checkType();
        $(document).on('change', 'select#type', function() {
            Cube.modules.checkType();
        });
    }

    // delete module
    $(document).on('click', '.btn-delete-module', function() {
        var id = $(this).data('id');
        Cube.modules.delete([id]);
        return false;
    });

    // delete all user
    $(document).on('click', '.btn-delete-all-module', function() {
        var list = $('.list-body.list-module input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn module nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.modules.delete(ids);
        return false;
    });

});