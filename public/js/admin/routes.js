/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.routes = {
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
    
    changeRouteType: function(type, target){
        if(type == 'bus'){
            $('#form-group-distance').hide();
        }
        else{
            $('#form-group-distance').show();
        }
        
        let sl = 'input#from_id';
        var select = $(sl).val();
        
        $(sl).val(0)
        Cube.ajax(this.urls.get_options_url, "POST", {type:type}, function(rs){
            var slt ='#from_id-wrapper-select .dropdown-menu';
            $(slt).find('.option-list').html(rs.options);
            $(slt).siblings('.btn.show-text-value').html(rs.default_text);
            $(sl).val(rs.default_value);
            if($(slt).find('.option-item').length>10){
                $(slt).find('.search-block').show();
                
            }else{
                $(slt).find('.search-block').hide();
            }   
        }.bind(this),function(e){
            $(sl).val(0);
            // $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
        }.bind(this));


        sl = 'input#to_id';
        var select = $(sl).val();
        
        $(sl).val(0)
        Cube.ajax(this.urls.get_end_options_url, "POST", {type:type}, function(rs){
            var slt ='#to_id-wrapper-select .dropdown-menu';
            $(slt).find('.option-list').html(rs.options);
            $(slt).siblings('.btn.show-text-value').html(rs.default_text);
            $(sl).val(rs.default_value);
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
    changePassingProvince: function(province_id, target){
        let sl = 'input#place_id';
        var select = $(sl).val();
        $(sl).val(0)
        Cube.ajax(this.urls.get_places_url, "POST", {province_id:province_id}, function(rs){
            var slt ='#place_id-wrapper-select .dropdown-menu';
            $(slt).find('.option-list').html(rs.options);
            $(slt).siblings('.btn.show-text-value').html($($(slt).find('.option-list a')[0]).html());
            $(sl).val(0);
            if($(slt).find('.option-item').length>10){
                $(slt).find('.search-block').show();
                
            }else{
                $(slt).find('.search-block').hide();
            }   
        }.bind(this),function(e){
            $(sl).val(0)
            // $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
        }.bind(this))
    },

    /**
     * add passing place
     * @param {string}
     * @param {object}
     */
    addPassingPlace: function(url, data){
        showLoading();
        Cube.ajax(url, "POST", data, function(rs){
            hideLoading();
            if(!rs.status){
                var message = "<strong>"+rs.message+"</strong><br/><br/>"+rs.errors.join('<br />');
                modal_alert(message);
            }else{
                modal_alert(rs.message, function(){
                    modal_hide_callback = function(){
                        showLoading();
                        top.location.reload();
                    };
                    
                });
            }
        }.bind(this),function(e){
            hideLoading();
            modal_alert("Lỗi không xác định!");
        });
    }

    
};

$(function() {
    if (typeof window.routesInit == 'function') {
        window.routesInit();
        window.routesInit = null;
    }
    if($('input#type').length){
        if($('input#type').val() == 'bus'){
            $('#form-group-distance').hide();
        }
        else{
            $('#form-group-distance').show();
        }
        
    }
    
    if($('#add-passing-place-form').length){
        $('#add-passing-place-form').submit(function(e){
            e.preventDefault();
            try{
                var url = $(this).attr('action');
                var data = $(this).serialize();
                Cube.routes.addPassingPlace(url, data);
            }
            catch(error){
                cl(error.getMessage());
            }
            return false;
        });
    }
});