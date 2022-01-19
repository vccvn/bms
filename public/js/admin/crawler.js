/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.crawler = {
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
    
    changeDynamic: function(id, target){
        let sl = 'input#cate_id';
        var select = $(sl).val();
        $(sl).val(0)
        Cube.ajax(this.urls.get_categories_url, "GET", {id:id, select:select}, function(rs){
            var slt ='#cate_id-wrapper-select .dropdown-menu';
            if(rs.status){
                $(slt).find('.option-list').html(rs.data);
                $(slt).siblings('.btn.show-text-value').html($($(slt).find('.option-list a')[0]).html());
            }else{
                $(slt).find('.option-list').html('');
                $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
            }
            $(sl).val(select)
        }.bind(this),function(e){
            $(sl).val(0)
            $(slt).siblings('.btn.show-text-value').html("-- Danh mục --");
        }.bind(this))
    }

};

$(function() {
    if (typeof window.crawlerInit == 'function') {
        window.crawlerInit();
        window.crawlerInit = null;
    }


});