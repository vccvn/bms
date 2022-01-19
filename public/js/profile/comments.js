// quan lis user
/**
 * doi tuong quan li user
 * @type {Object}
 */
Cube.comments = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},

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
    approve: function(ids) {
        Cube.ajax(Cube.comments.urls.approve_url, "POST", { ids: ids }, function(rs) {
            if (rs.status) {
                if (rs.list) {
                    for (var i = 0; i < rs.list.length; i++) {
                        $('#item-' + rs.list[i] + ' .btn-approve-comment').parent().hide(300, function() {
                            $(this).remove();
                        });
                    }

                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    unapprove: function(ids) {
        Cube.ajax(Cube.comments.urls.unapprove_url, "POST", { ids: ids }, function(rs) {
            if (rs.status) {
                if (rs.list) {
                    for (var i = 0; i < rs.list.length; i++) {
                        $('#item-' + rs.list[i] + ' .btn-unapprove-comment').parent().hide(300, function() {
                            $(this).remove();
                        });
                    }

                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });

    }
};

$(function() {
    if (typeof window.commentsInit == 'function') {
        window.commentsInit();
        window.commentsInit = null;
    }

    // delete comment
    $(document).on('click', '.btn-approve-comment', function() {
        var id = $(this).data('id');
        Cube.comments.approve([id]);
        return false;
    });

    // delete all comment
    $(document).on('click', '.btn-approve-all-comment', function() {
        var list = $('.list-body.list-item input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Bài viết nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.comments.approve(ids);
        return false;
    });

    // delete comment
    $(document).on('click', '.btn-approve-comment', function() {
        var id = $(this).data('id');
        Cube.comments.approve([id]);
        return false;
    });

    // delete all comment
    $(document).on('click', '.btn-approve-all-comment', function() {
        var list = $('.list-body.list-item input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Bài viết nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.comments.approve(ids);
        return false;
    });


    // delete comment
    $(document).on('click', '.btn-unapprove-comment', function() {
        var id = $(this).data('id');
        Cube.comments.unapprove([id]);
        return false;
    });

    // delete all comment
    $(document).on('click', '.btn-approve-all-comment', function() {
        var list = $('.list-body.list-item input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Bài viết nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.comments.unapprove(ids);
        return false;
    });

});