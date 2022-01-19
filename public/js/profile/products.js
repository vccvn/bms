// quan lis user
/**
 * doi tuong quan li user
 * @type {Object}
 */
Cube.products = {
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
        var msg = "bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length + " sản phẩm này" : "sản phẩm " + $('#product-name-' + ids[0]).text()) + "?";

        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(Cube.products.urls.delete_url, "POST", { ids: Cube.products.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#product-item-' + rs.remove_list[i]).hide(300, function() {
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
    if (typeof window.productsInit == 'function') {
        window.productsInit();
        window.productsInit = null;
    }

    // delete product
    $(document).on('click', '.btn-delete-product', function() {
        var id = $(this).data('id');
        Cube.products.delete([id]);
        return false;
    });

    // delete all product
    $(document).on('click', '.btn-delete-all-product', function() {
        var list = $('.list-body.list-product input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Sản phẩm nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.products.delete(ids);
        return false;
    });
});