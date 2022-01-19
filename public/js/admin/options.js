/**
 * doi tuong quan li option
 * @type {Object}
 */

Cube.options = {
    currentID: 0,
    listID: [],
    template: "",
    urls: {},
    option_group: "siteinfo",

    init_list: ["urls", "template", "option_group"],
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
    delete: function(ids) {
        this.listID = ids;
        modal_confirm("bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length : "") + " thiết lập này?", function(ans) {
            if (ans) {
                Cube.ajax(Cube.options.urls.delete_url, "POST", { ids: Cube.options.listID }, function(rs) {
                    if (rs.status) {
                        if (rs.remove_list) {
                            for (var i = 0; i < rs.remove_list.length; i++) {
                                $('#option-item-' + rs.remove_list[i]).hide(300, function() {
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
    form: function() {
        showModal('modal-add-web-option');
        this.showForm();
    },
    addItem: function() {
        var name = $('#add-web-option-item-form input#item-name').val();
        var type = $('#add-web-option-item-form select#item-type').val();
        var comment = $('#add-web-option-item-form textarea#item-comment').val();
        if (!name) {
            return this.alert("Vui lòng nhập tên thuộc tính!");
        }
        if (!name.match(/^[A-z]+[A-z0-9_]*$/g)) {
            return this.alert("Tên thuộc tính không hợp lệ.");
        }
        var data = { option_group: this.option_group, name: name, type: type, comment: comment };
        Cube.ajax(Cube.options.urls.add_item_url, "POST", data, function(rs) {
            if (rs.status) {
                if (rs.item.comment) {
                    rs.item.cmt = '<br>(' + rs.item.comment + ')';
                } else {
                    rs.item.cmt = '';
                }

                rs.item.input = Cube.str.eval(Cube.options.template.inputs[rs.item.type], rs.item);

                var group = Cube.str.eval(Cube.options.template.form_group, rs.item);
                $('form#option-form>.form-group:last-child').before(group);
                $('#add-web-option-item-form input#item-name').val('');
                hideModal('modal-add-web-option');
            } else {
                Cube.options.alert(rs.error);
            }
        });
    },
    showForm: function() {
        var slt = '#modal-add-web-option';
        $(slt + ' .form-alert').hide();
        $('#add-web-option-item-form').show();

    },
    alert: function(message) {
        var slt = '#modal-add-web-option';

        $('#add-web-option-item-form').hide();
        $(slt + ' .form-alert .message').html(message);
        $(slt + ' .form-alert').show();

    }
}



$(function() {
    if (typeof window.optionsInit == 'function') {
        window.optionsInit();
        window.optionsInit = null;
    }

    // delete option
    $(document).on('click', '.btn-delete-option-item', function() {
        var id = $(this).data('id');
        Cube.options.delete([id]);
        return false;
    });

    $(document).on('click', '.btn-add-option-item', function() {
        Cube.options.form();
        return false;
    });

    $(document).on('click', '#modal-add-web-option .btn-ok', function() {
        Cube.options.showForm();
        return false;
    });

    $('#add-web-option-item-form').submit(function() {
        setTimeout(function() {
            Cube.options.addItem();
        }, 100);
        return false;
    });
    jQuery.each(jQuery('textarea'), function() {
        var offset = this.offsetHeight - this.clientHeight;
     
        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        resizeTextarea(this);
        jQuery(this).on('keyup input', function() { resizeTextarea(this); });
    });

    $(document).keydown(function(event) {
        // If Control or Command key is pressed and the S key is pressed
        // run save function. 83 is the key code for S.
        if((event.ctrlKey || event.metaKey) && event.which == 83) {
            // Save Function
            event.preventDefault();
            $('#option-form').submit();
            return false;
        }
    });
});