/**
 * 
 * @type {Object}
 */
Cube.checkio = {
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
        $('').html('<div class="loading-block"><div class="lds-ripple"><div></div><div></div></div></div>');
        Cube.ajax(url,"GET",data,function(rs){
            if(rs.status){
                $('.trip-checkio .trip-result').html(rs.data);
            }else{
                $('.trip-checkio .trip-result').html('<div class="alert alert-danger text-center">'+rs.message+'</div>');
            }
        }, function(e){
            cl(e);
        });
    },
    log:function(id, status, action_type, color){
        var data = {
            id:id, 
            status:status, 
            action_type:action_type
        };
        if(action_type == 1){
            data.tickets = $('#trip-tickets-'+id).val();
        }
        Cube.ajax(this.urls.checkin_url, "POST", data, function(rs){
            if(rs.status){
                if(rs.data.status == status){
                    $('#trip-log-'+id).addClass('bg-'+color+' text-white');
                    $('#trip-log-'+id + ' .btn-change-status')
                        .addClass('disable')
                        .removeClass('btn-primary')
                        .removeClass('btn-success')
                        .removeClass('btn-danger')
                        .removeClass('btn-warning')
                        .removeClass('text-white')
                        .addClass('btn-secondary');
                    if(rs.data.status == 100){
                        $('#trip-log-'+id + ' .btn-cancel')
                        .removeClass('btn-danger')
                        .addClass('disable')
                        .addClass('btn-secondary');
                    }
                }
            }else{
                if(rs.errors.length){
                    modal_alert(rs.errors.join('<br/>'));
                }else if(rs.message){
                    modal_alert(rs.message);
                }else{
                    modal_alert('lỗi không xác định!');
                }
            }
        }.bind(this), function(e){
            cl(e)
        });
    },
    cancel:function(id){
        var data = {
            id:id
        };
        
        Cube.ajax(this.urls.cancel_url, "POST", data, function(rs){
            if(rs.status){
                $('#trip-log-'+id).addClass('bg-danger text-white');
                $('#trip-log-'+id + ' .btn-change-status')
                    .addClass('disable')
                    .removeClass('btn-primary')
                    .removeClass('btn-success')
                    .removeClass('btn-danger')
                    .removeClass('btn-warning')
                    .addClass('btn-secondary');
                $('#trip-log-'+id + ' .btn-cancel')
                    .removeClass('btn-danger')
                    .addClass('disable')
                    .addClass('btn-secondary');
        
            
            }else{
                if(rs.errors.length){
                    modal_alert(rs.errors.join('<br/>'));
                }else if(rs.message){
                    modal_alert(rs.message);
                }else{
                    modal_alert('lỗi không xác định!');
                }
            }
        }.bind(this), function(e){
            cl(e)
        });
    }
};

$(function() {
    if (typeof window.checkioInit == 'function') {
        window.checkioInit();
        window.checkioInit = null;
    }

    
    $(document).on('click', '.btn-change-status', function() {
        if($(this).hasClass('disable')) return false;
        var id = $(this).data('id');
        var status = $(this).data('status');
        var color = $(this).data('color');
        var type = $(this).data('type');
        
        Cube.checkio.log(id, status, type, color);
    });

    $(document).on('click', '.btn-cancel', function() {
        if($(this).hasClass('disable')) return false;
        var id = $(this).data('id');
        
        Cube.checkio.cancel(id);
    });

    if($('#checkin-form').length){
        $('#checkin-form').submit(function(e){
            Cube.checkio.search($(this).attr('action'), $( this ).serialize() );
            return false;
        });
    }

});