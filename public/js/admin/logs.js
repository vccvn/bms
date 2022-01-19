/**
 * 
 * @type {Object}
 */
Cube.logs = {
    currentID: 0,
    listID: [],
    urls: {},
    templates:{},
    init_list: ["urls", "templates"],
    status_list: { "1": "Hoàn thành", "0": "Chờ", "-1":"Bị Hủy" },
    status_color_types: {"0": "secondary", "1": "primary", "-1":"danger"},
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
    search:function(url, data){
        Cube.ajax(url,"GET",data,function(rs){
            if(rs.status){
                $('.trip-logs .trip-result').html(rs.data);
            }else{
                $('.trip-logs .trip-result').html('<div class="alert alert-danger text-center">'+rs.message+'</div>');
            }
        }, function(e){
            cl(e);
        })
    }
};

$(function() {
    if (typeof window.logsInit == 'function') {
        window.logsInit();
        window.logsInit = null;
    }

    
    // save update
    $(document).on('click', '.btn-change-status', function() {
        Cube.logs.saveUpdate();
    });

    if($('#checkin-form').length){
        $('#checkin-form').submit(function(e){
            Cube.logs.search($(this).attr('action'), $( this ).serialize() );
            return false;
        });
    }

});