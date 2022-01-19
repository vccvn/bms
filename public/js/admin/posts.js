// quan lis user
/**
 * doi tuong quan li user
 * @type {Object}
 */
Cube.posts = {
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
    delete: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length + " bài viết này" : "bài viết " + $('#post-title-' + ids[0]).text()) + "?";

        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(Cube.posts.urls.delete_url, "POST", { ids: Cube.posts.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#post-item-' + rs.remove_list[i]).hide(300, function() {
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
    searchProduct: function() {
        var keyword = $('#product-live-search-input').val();
        var cate_id = $('#product_cate_id').val();
        var post_id = $('#input-hidden-id').val();
        var $prodlink = $('.product-links');
        var $result = $prodlink.find('.search-results');
        var $linkd = $prodlink.find('.list-product-linked');
        if (Cube.str.replace(keyword, ' ', '').length) {
            Cube.ajax(Cube.posts.urls.search_product_url, "GET", { keyword: keyword, cate_id: cate_id, post_id: post_id }, function(rs) {
                if (rs.status) {
                    var msg = Cube.str.eval(Cube.posts.templates.message, { message: "Không có sản phẩm phù hợp" });
                    if (rs.products.length) {
                        var t = 0;
                        var results = "";
                        for (const item of rs.products) {
                            if (!Cube.posts.checkProduct(item.id)) {
                                results += Cube.str.eval(Cube.posts.templates.search_result, item);
                                t++;
                            }

                        }
                        if (t) {
                            var search_list = Cube.str.eval(Cube.posts.templates.search_list, { results: results, total: t });
                            $result.html(search_list);
                        } else {
                            $result.html(msg);
                        }
                    } else {
                        $result.html(msg);
                    }
                } else {
                    modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            }, function(e) {
                cl(e);
            })
        } else {
            var msg = Cube.str.eval(Cube.posts.templates.message, { message: "Bạn chưa nhập từ khóa" });
            $result.html(msg);
        }
    },
    getProductIdList: function() {
        var list = [];
        var $list = $('.input-group-hidden .input-product-hidden');
        if ($list.length) {
            for (var i = 0; i < $list.length; i++) {
                list[list.length] = $($list[i]).val();
            }
        }
        return list;
    },
    checkProduct: function(id) {
        var list = this.getProductIdList();
        for (var i = 0; i < list.length; i++) {
            if (list[i] == id) return true;
        }
        return false;
    },
    addProducts: function(ids) {
        var inputs = "";
        var inp = this.templates.hidden_product_input;
        var links = '';
        for (const id of ids) {
            if (!this.checkProduct(id)) {
                inputs += Cube.str.eval(inp, { id: id });
                links += Cube.str.eval(this.templates.linked_item, {
                    id: id,
                    name: $('#search-result-item-' + id + ' .product-name').html()
                });
            }
            $('#search-result-item-' + id).hide(400, function() {
                $(this).remove();
            });
        }
        $('.input-group-hidden').append(inputs);
        if ($('.list-product-linked .product-linked-list').length) {
            $('.list-product-linked .product-linked-list .list-body').append(links);
            $('.list-product-linked .product-linked-list .total-product').html(this.getProductIdList().length);
        } else {
            $('.list-product-linked').html(Cube.str.eval(this.templates.linked_list, { links: links, total: this.getProductIdList().length }));
        }
    },
    deleteProducts: function(ids) {
        for (const id of ids) {
            $('#product-linked-item-' + id).hide(400, function() {
                $(this).remove();
            });
            $('#product-hidden-' + id).remove();
        }
        $('.list-product-linked .product-linked-list .total-product').html(this.getProductIdList().length);
    }
};

$(function() {
    if (typeof window.postsInit == 'function') {
        window.postsInit();
        window.postsInit = null;
    }

    // delete post
    $(document).on('click', '.btn-delete-post', function() {
        var id = $(this).data('id');
        Cube.posts.delete([id]);
        return false;
    });

    // delete all post
    $(document).on('click', '.btn-delete-all-post', function() {
        var list = $('.list-body.list-post input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Bài viết nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.posts.delete(ids);
        return false;
    });

    // live search product
    if ($('.product-links').length) {
        $('#product-live-search-input').stop().keyup(function() {
            Cube.posts.searchProduct();
        });
        $('#btn-search-product').click(function() {
            Cube.posts.searchProduct();
        });
        $(document).on('click', '.search-result-list .btn-add-product-link', function() {
            var product_id = $(this).data('id');
            Cube.posts.addProducts([product_id]);
        });
        $(document).on('click', '.search-result-list .btn-add-all-product-link', function() {
            var list = $('.search-result-list .list-body input[type="checkbox"].check-item:checked');
            var ids = [];
            if (list.length == 0) {
                return modal_alert("Bạn chưa chọn sản phẩm nào!");
            }
            for (var i = 0; i < list.length; i++) {
                ids[ids.length] = $(list[i]).val();
            }
            Cube.posts.addProducts(ids);
        });


        $(document).on('click', '.product-linked-list .btn-delete-product-link', function() {
            var product_id = $(this).data('id');
            Cube.posts.deleteProducts([product_id]);
            return false;
        });
        $(document).on('click', '.product-linked-list .btn-delete-all-product-link', function() {
            var list = $('.product-linked-list .list-body input[type="checkbox"].check-item:checked');
            var ids = [];
            if (list.length == 0) {
                return modal_alert("Bạn chưa chọn sản phẩm nào!");
            }
            for (var i = 0; i < list.length; i++) {
                ids[ids.length] = $(list[i]).val();
            }
            Cube.posts.deleteProducts(ids);
            return false;
        });

    }

    // if ($('#post-form').length) {
    //     var not_pass_data = {
    //         title: "",
    //         content: "",
    //         cate_id: 0
    //     };
    //     $('#post-form').submit(function() {
    //         var msg = "";
    //         for (var n in not_pass_data) {
    //             var v = not_pass_data[n];
    //             if ($('#post-form *[name="' + n + '"]').val() == v) {
    //                 if (n == 'title') msg += (msg ? "<br>" : "") + "Chưa nhập tiêu đề";
    //                 else if (n == 'content') msg += (msg ? "<br>" : "") + "Chưa nhập nội dung";
    //                 else if (n == 'cate_id') msg += (msg ? "<br>" : "") + "Chưa chọn chủ dề";

    //             }
    //         }
    //         if (msg) {
    //             modal_alert(msg);
    //             return false;
    //         }
    //         return true;
    //     });
    // }
});