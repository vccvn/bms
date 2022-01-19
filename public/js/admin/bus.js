/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.bus = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},
    init_list: ["urls"],
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
    
    
    changeFreqDays: function(days, target){
        let sl = 'input#freq_trips';
        var select = $(sl).val();
        $(sl).val(1)
        Cube.ajax(this.urls.get_freq_trips_url, "POST", {days:days}, function(rs){
            var slt ='#freq_trips-wrapper-select .dropdown-menu';
            $(slt).find('.option-list').html(rs.options);
            $(slt).siblings('.btn.show-text-value').html($($(slt).find('.option-list a')[0]).html());
            $(sl).val(1);
            if($(slt).find('.option-item').length>10){
                $(slt).find('.search-block').show();
                
            }else{
                $(slt).find('.search-block').hide();
            }   
        }.bind(this),function(e){
            $(sl).val(1)
            // $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
        }.bind(this))
    },

    changeType: function(type){
        let sl = 'input#route_id';
        var select = $(sl).val();
        
        $(sl).val(0)
        Cube.ajax(this.urls.get_route_options_url, "POST", {type:type}, function(rs){
            var slt ='#route_id-wrapper-select .dropdown-menu';
            $(slt).find('.option-list').html(rs.options);
            $(slt).siblings('.btn.show-text-value').html($($(slt).find('.option-list a')[0]).html());
            $(sl).val(0);
            if($(slt).find('.option-item').length>10){
                $(slt).find('.search-block').show();
                
            }else{
                $(slt).find('.search-block').hide();
            }   
        }.bind(this),function(e){
            $(sl).val(0);
            // $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
        }.bind(this));


    },
    
};

$(function() {
    if (typeof window.busInit == 'function') {
        window.busInit();
        window.busInit = null;
    }

    function checkDateLimited(stt, delay){
        var selector = '#form-group-day_start, #form-group-day_stop';
        if(stt){
            $(selector).show(delay);
        }else{
            $(selector).hide(delay);
        }
    }

    if($('#date_limited').length){
        checkDateLimited($($('#date_limited')).is(':checked'), 0);
        $('#date_limited').change(function(){
            checkDateLimited($(this).is(':checked'), 300);
        });

    }
});