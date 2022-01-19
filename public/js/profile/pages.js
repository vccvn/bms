// quan lis page
/**
 * doi tuong quan li page
 * @type {Object}
 */
Cube.pages = {
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
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " trang này?", function(ans) {
            cl(Cube.pages.urls.delete_page_url);
            if (ans) {
                Cube.ajax(Cube.pages.urls.delete_url, "POST", { ids: Cube.pages.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {

                            for (var i = 0; i < rs.remove_list.length; i++) {
                                var rmid = rs.remove_list[i];
                                $('#page-item-' + rmid).hide(400, function() {
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

function checkPageType() {
    var t = $('#form-group-type input[type="radio"]:checked').val();
    if (t == 'dynamic') {
        $('#form-group-parent_id').removeClass('d-none').addClass('d-none');
    } else {
        $('#form-group-parent_id').removeClass('d-none');
    }
}
$(function() {
    if (typeof window.pagesInit == 'function') {
        window.pagesInit();
        window.pagesInit = null;
    }

    // delete page
    $(document).on('click', '.btn-delete-page', function() {
        var id = $(this).data('id');
        Cube.pages.delete([id]);
        return false;
    });

    // delete all page
    $(document).on('click', '.btn-delete-all-page', function() {
        var list = $('.list-body.list-page input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn page nào");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.pages.delete(ids);
        return false;
    });
    checkPageType();
    $('#form-group-type input[type="radio"]').click(function() {
        checkPageType();
    });
    $('#form-group-type input[type="radio"]').change(function() {
        checkPageType();
    });

});