/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.auth = {
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
    check:function(){
        Cube.ajax(this.urls.check, "POST", {_ssid:Cube.str.rand(16)}, function(rs){
            
            if(rs.status){
                var text = Cube.str.eval(this.templates.auth, rs.user);
                $('#header-auth-block').html(text);
            }
            
        }.bind(this));
    }
    
};

$(function() {
    if (typeof window.authInit == 'function') {
        window.authInit();
        window.authInit = null;
    }
    setTimeout(function(){
        Cube.auth.check();
    }, 100);

});