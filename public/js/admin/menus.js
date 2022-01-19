Cube.menus = {
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
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " menu này?", function(ans) {
            if (ans) {
                Cube.ajax(Cube.menus.urls.delete_menu_url, "POST", { ids: Cube.menus.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#menu-' + rs.remove_list[i]).hide(300, function() {
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
    checkDataType: function() {
        var t = $('#menu-form #type').val();
        var text = 'Dữ liệu';
        var s = true;
        if (t == 'json') {
            text = "Filename";
        } else if (t == 'define') {
            text = "Hàm / Phương thức"
        } else {
            s = false;
        }
        $('#label-for-data').html(text);
        $('input#data').prop('placeholder', text);

        if (s) {
            $('#form-group-data').removeClass('d-none');
        } else {
            $('#form-group-data').addClass('d-none');
        }

    },

    
};


$(function() {
    if (typeof window.menusInit == 'function') {
        window.menusInit();
        window.menusInit = null;
    }

    // menu
    if ($('form#menu-form').length > 0) {
        Cube.menus.checkDataType();
        $(document).on('change', 'select#type', function() {
            Cube.menus.checkDataType();
        });
    }

    // delete menu
    $(document).on('click', '.btn-delete-menu', function() {
        var id = $(this).data('id');
        Cube.menus.delete([id]);
    });

});