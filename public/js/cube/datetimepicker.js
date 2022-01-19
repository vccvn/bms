$(function(){
    if ($('input.inp-date').length) {
        $('.inp-date').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD'
        });
    }
    if ($('input.inp-time').length) {
        $('.inp-time').datetimepicker({
            locale: 'vi',
            format: 'HH:mm:ss'
        });
    }
    if ($('input.inp-datetime').length) {
        $('.inp-datetime').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    }

    var dtp = $('input.datetime-picker');
    if(dtp.length){
        dtp.each(function(ind, e){
            let format = 'YYYY-MM-DD HH:mm:ss';
            let $e = $(e);
            if($e.data('format')){
                format = $e.data('format');
            }else if($e.hasClass('date-format')){
                format = 'YYYY-MM-DD';
            }else if($e.hasClass('time-format')){
                format = 'HH:mm:ss';
            }
            $e.datetimepicker({
                locale: 'vi',
                format: format
            });
        });
    }


    var dt = $('.bms-datetime-picker');
    if(dt.length){
        dt.each(function(ind, e){
            let format = 'YYYY-MM-DD HH:mm:ss';
            let $e = $(e);
            if($e.data('format')){
                format = $e.data('format');
            }else if($e.hasClass('date-format')){
                format = 'YYYY-MM-DD';
            }else if($e.hasClass('time-format')){
                format = 'HH:mm:ss';
            }
            $e.datetimepicker({
                locale: 'vi',
                format: format
            });
        });
    }
});