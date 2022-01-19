/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.schedules = {
    currentID: 0,
    listID: [],
    urls: {},

    day_start:1,
    day_stop: 31,
    freq_days:1,
    days_available:[],
    time_start:21600,
    time_end: 64800,
    time_between: 1800,
    current_date:'',
    today:0,
    init_list: [
        "urls", 'day_start','day_stop','freq_days', 'time_start', 'time_end', 'time_between', 'month_trips', 'days_available',
        'current_date','today'
    ],
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
    
    toggleCheckIn:function(status){
        //
        var selector = '.go-in .day-available input[type=checkbox]';
        if(status){
            
            // neu duoc chon 1 o đâu tiên
            if($(selector+':checked').length){
                var $first = $($(selector+':checked')[0]);
                var day = parseInt($first.data('day'));
                $(selector).prop('checked', false);
                while(day <= this.day_stop){
                    $(selector+'.day-'+day).prop('checked', true);
                    day+=this.freq_days;
                }
            }
            else if(this.freq_days > 1){
                var msg = '';
                if(this.days_available.length>0){
                    msg = 'Vui lòng chọn ngày đầu tiên';
                }else{
                    msg = 'Bạn không thể lên lịch trình cho tháng này được nữa!';
                }
                modal_alert(msg);
                $('.go-back .check-all input[type=checkbox]').prop('checked',false);
            }else{
                $(selector).prop('checked', true);
            }
        }
        else{
            $(selector).prop('checked', false);
        }
    },

    toggleCheckOut:function(status){
        //
        var selector = '.go-out .day-available input[type=checkbox]';
        if(status){
            
            // neu duoc chon 1 o đâu tiên
            if($(selector+':checked').length){
                var $first = $($(selector+':checked')[0]);
                var day = parseInt($first.data('day'));
                $(selector).prop('checked', false);
                while(day <= this.day_stop){
                    $(selector+'.day-'+day).prop('checked', true);
                    day+=this.freq_days;
                }
            }
            else if(this.freq_days > 1){
                var msg = '';
                if(this.days_available.length>0){
                    msg = 'Vui lòng chọn ngày đầu tiên';
                }else{
                    msg = 'Bạn không thể lên lịch trình cho tháng này được nữa!';
                }
                modal_alert(msg);
                $('.go-forward .check-all input[type=checkbox]').prop('checked',false);
            }else{
                $(selector).prop('checked', true);
            }
        }
        else{
            $(selector).prop('checked', false);
        }
    },
    delete: function(bus_id, month, year) {

        var msg = "bạn có chắc chắn muốn xóa lịch trình của xe " + $('#item-name-' + bus_id).data('name') + "?";
        modal_confirm(msg, function(ans) {
            if (ans) {
                Cube.ajax(this.urls.delete_url, "POST", { bus_id:bus_id, month:month, year:year }, function(rs) {
                    if (rs.status) {
                        $('#item-' + rs.data.id).hide(400, function() {
                            $(this).remove();
                        });
                    }else if(rs.errors.length){
                        modal_alert(rs.errors.join('<br />'));
                    } 
                    else {
                        modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                });
            }
        }.bind(this));
    }

};

$(function() {
    if (typeof window.schedulesInit == 'function') {
        window.schedulesInit();
        window.schedulesInit = null;
    }

    $('.go-forward .check-all input[type=checkbox]').click(function(e){
        var stt = $(this).is(':checked');
        Cube.schedules.toggleCheckOut(stt);
    });
    $('.go-back .check-all input[type=checkbox]').click(function(e){
        var stt = $(this).is(':checked');
        Cube.schedules.toggleCheckIn(stt);
    });


    $('.btn-delete-schedule').click(function(e){
        var bus_id = $(this).data('bus-id');
        var month = $(this).data('month');
        var year = $(this).data('year');
        Cube.schedules.delete(bus_id, month, year);
        return false;
    });
    
});