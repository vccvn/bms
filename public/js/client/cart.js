Cube.cart = {
    currentID: 0,
    listID: [],
    urls: {},
    VAT: 20,
    template: '<li id="cart-item-{$id}"><div class="whishlist-item"><div class="product-image"><a href="{$link}" title="{$name}"><img src="{$image}" alt=""></a></div><div class="product-body"><div class="whishlist-name"><h3><a href="{$link}" title="{$name}">{$name}</a></h3></div><div class="whishlist-price"><span>Giá: </span><strong>{$price}</strong></div><div class="whishlist-quantity"><span>Só lượng: </span><span>{$qty}</span></div></div></div><a href="#" title="" class="remove btn-remove-item" data-id="{$id}"><i class="icon icon-remove"></i></a></li>',
    init_list:['urls','template', 'VAT'],
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

    updateCartTotal:function(total){
        $('.cart-btn .cart-qty').html(total);
    },
    updateCartHtml: function(product, total, money) {
        this.updateCartTotal(total);
        Cube.storage.set("cart_total",total);
        if (product) {
            for(var i = product.length - 1; i >= 0; i--) {
                var p = product[i];
                var item_total = Cube.number.currency(p.total_price);
                $('#item-total-price-'+p.key).html(item_total);
            }        
        }
        var money_total = Cube.number.currency(money);
        var money_total_vat = Cube.number.currency(money + (money * this.VAT / 100));
        //$('.cart-product-list').html(a);
        //$('.cart-item-count').html(total);
        $('.cart-total-money').html(money_total + " VNĐ");
        $('.cart-total-money-vat').html(money_total_vat + " VNĐ");

        

    },
    add: function(id, qty) {
        if (!qty) {
            qty = 1;
        }
        this.currentID = id;
        Cube.ajax(this.urls.add, "POST", { id: id, qty: qty }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                modal_alert("Sản phẩm đã được thêm vào giỏ hàng thành công");
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    shopNow: function(id, qty) {
        if (!qty) {
            qty = 1;
        }
        this.currentID = id;
        Cube.ajax(this.urls.add, "POST", { id: id, qty: qty }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                location.href = Cube.cart.urls.checkout;
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    addWithProps: function(id, props, qty) {
        if (!qty) {
            qty = 1;
        }
        if (!props || props.length == 0) {
            props = [];
        }
        this.currentID = id;
        Cube.ajax(this.urls.add, "POST", { id: id, properties: props, qty: qty }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                modal_alert("Sản phẩm đã được thêm vào giỏ hàng thành công");
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    update: function(data) {
        Cube.ajax(this.urls.update, "POST", { products: data }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                //modal_alert("Sản phẩm đã được cập nhật thành công");
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    updateQtyByKey: function(key, qty) {
        Cube.ajax(this.urls.update_by_key, "POST", { key: key, qty: qty }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                //modal_alert("Sản phẩm đã được cập nhật thành công");
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    updateCart: function(data) {
        Cube.ajax(this.urls.update_cart, "POST", { products: data }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                //modal_alert("Sản phẩm đã được cập nhật thành công");
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    remove: function(product_key) {
        this.currentID = product_key;
        Cube.ajax(this.urls.remove, "POST", { key: product_key }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
                //modal_alert("Sản phẩm đã được gỡ bỏ khỏi giỏ hàng");
                if (rs.remove_key) {
                    if ($('#product-cart-item-' + rs.remove_key).length) {
                        $('#product-cart-item-' + rs.remove_key).hide(400, function() {
                            $(this).remove();
                        });
                    }
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    refresh: function() {
        Cube.ajax(this.urls.refresh, "GET", { hhhh: 0 }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml(rs.products, rs.total_qty, rs.total_money);
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    },
    empty: function() {
        Cube.ajax(this.urls.empty, "GET", { hhhh: 0 }, function(rs) {
            if (rs.status) {
                Cube.cart.updateCartHtml([], 0, 0);
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        });
    }
};

$(function() {
    function changrItemQty($input, status) {
        if ($input.length) {
            var val = parseInt($input.val());

            if (!isNaN(val)) {
                var old = val;
                if (status) val++;
                else if (val > 1) val--;
                $input.val(val);
                if (val != old) {
                    Cube.cart.updateQtyByKey($input.data('key'), val);
                }
            }

        }
    }
    if (typeof window.cartInit == 'function') {
        window.cartInit();
        window.cartInit = null;
    }


    $(document).on('click', '.btn-add-to-cart', function() {
        var id = $(this).data('id');
        Cube.cart.add(id);
        return false
    });

    $(document).on('click', '.btn-shop-now', function() {
        var id = $(this).data('id');
        Cube.cart.shopNow(id);
        return false
    });

    $(document).on('click', '.btn-add-to-cart-with-qty', function() {
        var id = $(this).data('id');
        var qty = 1;
        if ($('#product-quantity').length > 0) {
            qty = Number($('#product-quantity').val());
        }
        Cube.cart.add(id, qty);
        return false
    });




    $(document).on('click', '.btn-remove-cart-item', function() {
        var product_key = $(this).data('key');
        Cube.cart.remove(product_key);
        return false;
    });

    $(document).on('click', '.btn-empty-cart', function() {
        Cube.cart.empty();
        return false;
    });

    $(document).on('change', '.cart-section .item-quantity', function() {
        var product_key = $(this).data('key');
        var qty = Number($(this).val());
        if (!isNaN(qty) && qty > 0) {
            Cube.cart.updateQtyByKey(product_key, qty);
        } else {
            modal_alert("Số lượng phải là số và lớn hơn 0");
        }
        return false;
    });

    $('.btn-go-to-checkout').click(function () {
        top.location.href = Cube.cart.urls.checkout;
        return false;
    })
    $('.btn-update-cart').click(function() {
        var items = $('.cart-section .item-quantity');
        if(items.length){
            var data = {};
            for(var i = 0; i < items.length; i++){
                var $item = $(items[0]);
                var key = $item.attr('name');
                var qty = $item.val();
                data[key] = qty;
            }
            Cube.cart.updateCart(data);
        }
        return false;
    });

    $('.btn-change-item-qty').click(function() {
        changrItemQty($($(this).parent().children('input')[0]), $(this).hasClass('increase'));
    });


    $(document).on('click', '.btn-add-cart-with-properties', function() {
        var id = $('.order-product-id').val();
        var qty = Number($('.order-product-quantity').val());
        var props = [];
        var notselect = [];
        var p = $('.order-product-property');
        if (p.length > 0) {
            for (var i = 0; i < p.length; i++) {
                var v = $(p[i]).val();
                if (v == 'NONE') {
                    notselect[notselect.length] = $(p[i]).data('label');

                } else {
                    props[props.length] = v;
                }
            }
        }
        if (notselect.length) {
            modal_alert("bạn chưa chọn <strong>" + notselect.join(', ') + "</strong>");
            return false;
        }
        Cube.cart.addWithProps(id, props, qty);
        return false
    });
    var total = Cube.storage.get('cart_total');
    if (total !== null) {
        Cube.cart.updateCartTotal(total);
    } else {
        Cube.cart.refresh();
    }



    if($('#order-checkout-form').length){
        $('#order-checkout-form').submit(function(){
            var labels = {name:'Họ tên',email:'Địa chỉ email', phone_number: 'Số điện thoại', address:'Địa chỉ giao hàng'};
            var data = {};
            var inputs = $(this).find('.order-input');
            var errors = [];
            for(var i = 0; i < inputs.length; i++){
                var $inp = $(inputs[i]); 
                var name = $inp.attr('name');
                var val = $inp.val();
                if(typeof(labels[name]) != 'undefined'){
                    var label = labels[name];
                    if(val.length<1){
                        errors.push('Bạn chưa nhập <strong>'+label+'</strong>!');
                    }else if(name == 'email' && !Cube.validateEmail(val)){
                        errors.push('<strong>'+label+'</strong> không hợp lệ!');
                    }else{
                        data[name] = val;
                    }
                }else{
                    data[name] = val;
                }
            }
            if(errors.length){
                modal_alert(errors.join('<br>'))
                return false;
            }
            Cube.storage.remove('cart_total');
            let $btn = $(this).find('.btn-place-order');
            if($btn.length){
                $btn.html("Đang xử lý...");
                $btn.attr('type','button');
            }
            return true;
        });
    }
});