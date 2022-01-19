/**
 * doi tuong quan li role
 * @type {Object}
 */
Cube.roles = {
    currentID: 0,
    listID: [],
    list: {},
    current_role_id: 0,
    current_role_users: [],
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
        if (typeof args.list != 'undefined') {
            this.list = args.list
        }
    },
    delete: function(ids) {
        this.listID = ids;
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " quyền này?", function(ans) {
            if (ans) {
                Cube.ajax(Cube.roles.urls.delete_role_url, "POST", { ids: Cube.roles.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#role-item-' + rs.remove_list[i]).hide(300, function() {
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

}

$(function() {
    if (typeof window.rolesInit == 'function') {
        window.rolesInit();
        window.rolesInit = null;
    }

    // delete role
    $(document).on('click', '.btn-delete-role', function() {
        var id = $(this).data('id');
        if (id == 1 || id == 2) {
            return modal_alert('Bạn không thể xóa quyền này');
        }
        Cube.roles.delete([id]);
        return false;
    });

    // delete all role
    $(document).on('click', '.btn-delete-all-role', function() {
        var list = $('.list-body.list-role input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn quyền nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.roles.delete(ids);
        return false;
    });



});