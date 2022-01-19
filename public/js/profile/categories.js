// quan lis user
/**
 * doi tuong quan li user
 * @type {Object}
 */
Cube.categories = {
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
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " chủ đề này?", function(ans) {
            if (ans) {
                Cube.ajax(Cube.categories.urls.delete_url, "POST", { ids: Cube.categories.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#category-item-' + rs.remove_list[i]).hide(300, function() {
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
    }
};

$(function() {
    if (typeof window.categoriesInit == 'function') {
        window.categoriesInit();
        window.categoriesInit = null;
    }

    // delete category
    $(document).on('click', '.btn-delete-category', function() {
        var id = $(this).data('id');
        Cube.categories.delete([id]);
        return false;
    });

    // delete all category
    $(document).on('click', '.btn-delete-all-category', function() {
        var list = $('.list-body.list-category input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn chủ đề nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.categories.delete(ids);
        return false;
    });
});