/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.comments = {
    urls: {},
    templates: {},
    init_list: ["urls", "templates"],
    validator:{
        name:{
            label:"Họ tên",
            check:function(val){
                return (val.length != 0);
            },
            message:"Bạn chưa nhập họ tên!"
        },
        email:{
            label:"Email",
            check:function(val){
                return Cube.validateEmail(val);
            },
            message:"Email không hợp lệ!"
        },
        content:{
            label:"Nội dung",
            check:function(val){
                return (val.length != 0);
            },
            message: "Nội dung không dược bỏ trống",
        }
    },
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

    add: function(data, callback) {
        if(!this.urls.save_url) return true;
        Cube.ajax(this.urls.save_url,"POST", data, function(rs){
            if(rs.status){
                if(typeof callback === 'function'){
                    callback();
                }
                modal_alert("Bình luận của bạn đã được gửi thành công và đang chờ phê duyệt");
            }else{
                modal_alert(rs.errors.join("<br>"));
            }
        });
        return false;
    }
};

$(function() {
    if (typeof window.commentsInit == 'function') {
        window.commentsInit();
        window.commentsInit = null;
    }


    $('#leave-comment-form').submit(function(){
        var inputs = $(this).find('.cmt-input');
        var data = {};
        var errors = [];
        var cv = Cube.comments.validator;
        for(var i = 0; i < inputs.length; i++){
            var $inp = $(inputs[i]);
            var name = $inp.attr('name');
            var val = $inp.val();
            var lb = name;
            var ie = false;
            if(typeof cv[name] != 'undefined'){
                lb = cv[name].label;
                ie = true;
            }
            if(ie && val.length < 1){
                errors.push(lb+" không được bỏ trống!");
            }else if(ie){
                if(cv[name].check(val)){
                    data[name] = val;
                }else{
                    errors.push(cv[name].message);
                }
            }else{
                data[name] = val;
            }
        }
        if(errors.length>0){
            modal_alert(errors.join("<br />"));
            return false;
        }
        else{
            return Cube.comments.add(data, function(){
                inputs.val('');
            });
        }
    });
});
