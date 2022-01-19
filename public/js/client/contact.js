/**
 * doi tuong quan li item
 * @type {object}
 */
Cube.contact = {
    urls: {},
    templates: {},
    init_list: ["urls", "templates"],
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
    send:function(form){
        try{
            let data = {};
            let errors = [];
            
            $(form).find('.inp').each(function(index, el){
                let $inp = $(el);
                let name = $inp.attr('name');
                let value = $inp.val();
                data[name] = value;
                //cl(el);
            });
            let url = $(form).attr('action');
            let btn = $(form).find('.submit-contact');
            if(btn.length){
                btn.prop('disable', true);
                btn.html('Đang gửi liên hệ...');
                btn.removeClass('btn-primary').addClass('btn-default');
                btn.attr('type', 'button');
            }
            Cube.ajax(url, 'post', data, function(res){
                if(res.status){
                    modal_alert("Bạn đã gửi liên hệ thành công! <br />Chúng tôi sẽ phản hồi trong thời gian sớm nhất!");
                    $(form).find('.inp').each(function(ind, el){
                        let $inp = $(el);
                        $inp.val('');
                    });
                }else if(res.errors){
                    modal_alert(res.errors.join('<br>'));
                }
                if(btn.length){
                    btn.prop('disable', false);
                    btn.html('Gửi');
                    btn.removeClass('btn-default').addClass('btn-primary');
                    btn.attr('type', 'submit');
                }
                
            });
        }
        catch(e){
            modal_alert("Đã có lỗi bất ngờ xảy ra. vui lòng thử lại trong giây lát");
        }
    }
    
};

$(function() {
    if (typeof window.contactInit == 'function') {
        window.contactInit();
        window.contactInit = null;
    }

    $('.contact-form').submit(function(){
        Cube.contact.send(this);
        return false;
    });
});