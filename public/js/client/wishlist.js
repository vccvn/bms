Cube.wishlist = {
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
    updateHtml: function(product) {
        var p = '<li id="wishlist-item-{$id}">' +
            '<div class="whishlist-item">' +
            '<div class="product-image">' +
            '<a href="{$link}" title="{$name}"><img src="{$image}" alt="{$name}"></a>' +
            '</div>' +
            '<div class="product-body">' +
            '<div class="whishlist-name">' +
            '<h3><a href="{$link}" title="{$name}">{$name}</a></h3>' +
            '</div>' +

            '<div class="whishlist-price">' +
            '<span>Giá: </span>' +
            '<strong>{$price}</strong>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<a href="#" title="" class="remove btn-remove-item" data-id="{$id}"><i class="icon icon-remove"></i></a>' +
            '</li>';
        var a = '';
        if (product) {
            for (let i = product.length - 1; i >= 0; i--) {
                if (product.length - i < 5) {
                    var pd = product[i];
                    a += Cube.str.eval(p, pd);
                }
            }
            if (product.length > 4) {
                a += "<li><p>còn nữa...</p></li>"
            }
        }
        $('#wishlist-products').html(a);
        if (product.length > 0) {
            $('#wishlist-products').parent().removeClass('emptylist');
        } else {
            if (!$('#wishlist-products').parent().hasClass('emptylist')) {
                $('#wishlist-products').parent().addClass('emptylist');
            }
        }

    },
    add: function(id) {
        this.currentID = id;
        Cube.ajax(this.urls.add, "POST", { id: id }, function(rs) {
            if (rs.status) {
                Cube.wishlist.updateHtml(rs.products);
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    remove: function(id) {
        this.currentID = id;
        Cube.ajax(this.urls.remove, "POST", { id: id }, function(rs) {
            if (rs.status) {
                Cube.wishlist.updateHtml(rs.products);
                if (rs.remove_id) {
                    if ($('#product-in-wishlist-' + rs.remove_id).length) {
                        $('#product-in-wishlist-' + rs.remove_id).hide(400, function() {
                            $(this).remove();
                        });
                    }
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    refresh: function(id) {
        Cube.ajax(this.urls.refresh, "GET", { h: 0 }, function(rs) {
            if (rs.status) {
                Cube.wishlist.updateHtml(rs.products);
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    }
};


$(function() {
    if (typeof window.wishlistInit == 'function') {
        window.wishlistInit();
        window.wishlistInit = null;
    }


    $(document).on('click', '.product-quick-whistlist', function() {
        var id = $(this).data('id');
        Cube.wishlist.add(id);
        return false
    });
    $(document).on('click', '.btn-add-to-wishlist', function() {
        var id = $(this).data('id');
        Cube.wishlist.add(id);
        return false
    });





    $(document).on('click', '.menubar-wishlist .btn-remove-item', function() {
        var id = $(this).data('id');
        Cube.wishlist.remove(id);
        return false;
    });
    $(document).on('click', '.product-remove-whistlist', function() {
        var id = $(this).data('id');
        Cube.wishlist.remove(id);
        return false;
    });


});