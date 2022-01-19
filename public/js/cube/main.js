var Cube = {
    urls: {
        
    },
    init: function(args) {
        if (typeof args.urls == 'object') {
            for (var url_name in args.urls) {
                this.urls[url_name] = args.urls[url_name];
            }
        }
    },
    /**
     * using this method instead of jquery.ajax
     * @param {string} url duong dan
     * @param {string} method phuong thuc
     * @param {object} data du lieu
     * @param {function} success
     * @param {function} error
     * 
     * @return {boolean}
     */
    ajax: function(url, method, data, success, error) {
        if (typeof success != 'function') success = cl;
        if (typeof error != 'function') error = cl;
        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'JSON',
            cookie: true,
            success: success,
            error: error
        });
    }
};
Cube.getType = function(obj) {
    var t = 'null';
    if (typeof obj == 'object') {
        if (obj == null) {
            t = 'null';
        } else if (obj.constructor == FormData) {
            t = 'formdata';
        } else if (obj.constructor == Array) {
            t = 'array';
        } else if (obj.constructor == Object) {
            t = 'object';
        } else if (obj.constructor == Number) {
            t = 'number';
        } else {
            t = 'object';
        }
    } else {
        t = typeof obj;
    }
    return t;
};
Cube.validateEmail = function (email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};

// authoe Doan ln

/**
 * console.log
 * @param {*} ob 
 */

function cl(ob) {
    console.log(ob);
}


var modal_confirm_callback = cl;

var modal_hide_callback = null;

var modal_show_callback = null;

var has_modal_is_on = false;

var current_modal_open = null;
var last_modal_open = null;
var modal_waiting_for_hide = false;

function showModal(id, callback_show) {
    if (id == current_modal_open) return true;;
    
    if (has_modal_is_on) {
        if (typeof callback_show == 'function') {
            modal_waiting_for_hide = callback_show;
        }
        hideModal(null, function() {
            if (typeof modal_waiting_for_hide == 'function') {
                showModal(id, modal_waiting_for_hide);
            }else{
                showModal(id);
            }
            
        });
    } else {
        if (typeof callback_show == 'function') {
            modal_show_callback = callback_show;
        }    
        $('#' + id).modal('show');
    }

}

function hideModal(id, callback) {
    if (typeof callback == 'function') {
        modal_hide_callback = callback;
    }
    if (id) {
        $('#' + id).modal('hide');
    } else {
        $('.modal').modal('hide');
    }
}

/**
 * 
 * @param {string} message 
 * @param {function} callback 
 */
function modal_confirm(message, callback) {
    if (typeof(callback) == 'function') {
        modal_confirm_callback = callback;
    } else {
        modal_confirm_callback = cl;
    }
    $('#modal-confirm .modal-message').html(message);
    showModal('modal-confirm');
}


function modal_answer(stt) {
    modal_confirm_callback(stt ? true : false);
}


function modal_alert(message, callback) {
    $('#modal-alert .modal-message').html(message);
    showModal('modal-alert', callback);

}

/**
 * 
 * @param {object} data 
 */
function custom_modal(data) {
    if (data) {
        var t = Cube.getType(data);
        if (t == 'object') {
            var title = data.title ? data.title : '';
            var content = data.content ? data.content : '';
            var buttons = '';
            var btns = [];
            if (data.buttons) {
                var btnData = data.buttons;
                var bt = Cube.getType(btnData);
                if (bt == 'object') {
                    btns[0] = btnData;
                } else if (bt == 'array') {
                    btns = btnData;
                }

                for (var i = 0; i < btns.length; i++) {
                    var btn = btns[i];
                    var btnText = 'Button';
                    var btnHtml = '<button';
                    if (!btn.type) {
                        btnHtml += ' type="Button"';
                    }
                    for (var prop in btn) {
                        var key = prop.toLowerCase();
                        var val = btn[prop];
                        if (key == 'text') {
                            btnText = val;
                        } else if (key == 'classname' || key == 'class') {
                            btnHtml += ' class="' + val + '"';
                        } else {
                            btnHtml += ' ' + prop + '="' + val + '"';
                        }
                    }
                    btnHtml += '>' + btnText + '</button> ';
                    buttons += btnHtml;
                }
            }
            $('#custom-modal .custom-modal-content').html(content);
            $('#custom-modal .modal-title').html(title);
            $('#custom-modal .modal-buttons').html(buttons);
            if (data.size) {
                $('#custom-modal .modal-dialog').removeClass().addClass('modal-dialog modal-' + data.size);
            }
            showModal('custom-modal');
        }
    }
}

function createJS(d, s, src, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement(s);
    js.id = id;
    js.src = src;
    fjs.parentNode.insertBefore(js, fjs);
};

function checkAll() {
    $('input[type="checkbox"].check-item,input[type="checkbox"].check-all').prop('checked', true);
}

function unCheckAll() {
    $('input[type="checkbox"].check-item,input[type="checkbox"].check-all').prop('checked', false);
}


function showLoading(){
    $('.loading-lightbox').show();
}
function hideLoading(){
    $('.loading-lightbox').hide();
}



$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var ajaxNaseUrl = '/admin';
    if ($('#ajax-base-url')) {
        ajaxNaseUrl = $('#ajax-base-url').data('url') || $('#ajax-base-url').val();
    }


    if ($('#modal-confirm').length > 0) {
        $('#modal-confirm .btn-confirm-answer').click(function() {
            var $this = $(this);
            if ($this.hasClass('yes')) {
                modal_answer(true);
            } else {
                modal_answer(false);
            }
            $('#modal-confirm').modal('hide');
        });

        $('.modal').on('hidden.bs.modal', function() {
            has_modal_is_on = false;
            last_modal_open = current_modal_open;
            current_modal_open = null;
            if (typeof modal_hide_callback == 'function') {
                modal_hide_callback();
                modal_hide_callback = null;
            }

        });
        $('.modal').on('show.bs.modal', function(e) {
            has_modal_is_on = true;
            current_modal_open = $(this).attr('id');
            if (typeof modal_show_callback == 'function') {
                modal_show_callback();
                modal_show_callback = null;
            }
        });
    }

    $(document).on('click', 'input[type="checkbox"].check-all', function() {
        if ($(this).is(':checked')) {
            checkAll();
        } else {
            unCheckAll();
        }
    });
    $('.btn-check-all').click(function() {
        if ($('input[type="checkbox"].check-all').is(':checked')) {
            unCheckAll();
        } else {
            checkAll();
        }
        return false;
    });
    $(document).on('click', 'input[type="checkbox"].check-item', function() {
        var s = true;
        var cs = $('input[type="checkbox"].check-item');
        for (var i = 0; i < cs.length; i++) {
            if (!$(cs[i]).is(':checked')) {
                s = false;
            }
        }
        if (s) {
            $('input[type="checkbox"].check-all').prop('checked', true);
        } else {
            $('input[type="checkbox"].check-all').prop('checked', false);
        }
    });


    $(document).on('change', '.form-input-file-group input.input-hidden-file', function() {
        var txtFile = $(this).parent().find('.input-file-fake');
        if (this.files.length > 0) {
            var filename = this.files[0].name;

            if (filename) {
                $(txtFile).val(filename);
            } else {
                $(txtFile).val("");
            }
        } else {
            $(txtFile).val("");
        }
    });




    $('.cube-tab .tab .tab-link').click(function(){
        var s = $(this).attr('href');
        $(this).parent().find('.tab-link').removeClass('active');
        $(this).addClass('active');
        $(this).parent().parent().find('.tab-content-item').removeClass('active');
        $(s).addClass('active');
        return false;
    });

});