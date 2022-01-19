/**
 * 
 * @type {Object}
 */
Cube.trips = {
    currentID: 0,
    listID: [],
    urls: {},
    templates:{},
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
    search:function(data){
        $('.trip-page .result-data').html('<div class="loading-wrapper"><div class="lds-facebook"><div></div><div></div><div></div></div></div>');
        Cube.ajax(this.urls.ajax_search, "GET", data, function(rs){
            if(rs.data){
                $('.trip-page .result-data').html(rs.data);
            }else{
                $('.trip-page .result-data').html('<div class="alert alert-danger text-center">Lỗi không xác định!</div>');
            }
        },function(e){
            $('.trip-page .result-data').html('<div class="alert alert-danger text-center">Lỗi không xác định!</div>');
        });
    },

    detail:function(id){
        Cube.ajax(this.urls.ajax_detail, "GET", {id:id}, function(rs){
            if(rs.data){
                custom_modal({
                    title: "Chi tiết chuyến",
                    content: rs.data,
                    size:'lg'
                });
            }else{
                modal_alert('Lỗi không xác định');
            }
        },function(e){
            
        });
    }
};

$(function() {
    if (typeof window.tripsInit == 'function') {
        window.tripsInit();
        window.tripsInit = null;
    }

    if($('#trip-search-form').length){
        $('#trip-search-form').submit(function (e) { 
            try{
                var data = $( this ).serialize();
                Cube.trips.search(data);
            }catch(e){

            }
            return false;
            
        });
    }

    $(document).on('click', '.btn-view-journey', function(){
        Cube.trips.detail($(this).data('id'));
    });

});