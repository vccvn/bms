$(function(){
    let $static = $('.cube-select-group.static');
    if($static.length){
        $static.map(function (index, select) {
            if($(select).find('.option-item').length>10 && !$(select).hasClass('disable-search')){
                $(select).find('.search-block').show();
                
            }else{
                $(select).find('.search-block').hide();
            }    
        })
        
    }
    $('.cube-select-group .dropdown-menu').on('click', function (e) {
        var el = e.target;
        var tag = el.tagName.toLowerCase();
        if(tag != 'a'){
            e.stopPropagation();
        }else{
            var $el = $(el);
            if($el.hasClass('dropdown-item')){
                var value = $el.data('value');
                let isl = 'input#'+$(this).data('ref');
                let old = $(isl).val();
                if(value != old){
                    var text = $el.data('text');
                    $(this).siblings('.btn.show-text-value').html(text);
                    $(this).siblings('.btn.show-text-value').val(value);
                    $(isl).val(value);
                    $(this).find('.option-item').removeClass('active');
                    $el.addClass('active');
                    var onc = $(this).parent().parent().data('changed-callback');
                    if(onc){
                        var fn = new Cube.fn();
                        if(fn.check(onc)){
                            fn.call(onc,[value,el]);
                        }
                    }
                }
            }
        }
    });


    $('.cube-select-group.static .dropdown-menu').on('keyup mouseup', function (e) {
        var el = e.target;
        var tag = el.tagName.toLowerCase();
        if(tag=='input' && $(el).hasClass('search-option-input')){
            var text = el.value.toLocaleLowerCase();
            var text2 = Cube.str.replace(Cube.str.clearUnicode(text), ' ', '').toLocaleLowerCase();
            var cc = 0;
            cl(text2);
            
            $(this).find('.option-list>.option-item').each(function (ind, elem) {
                var txt = $(elem).data('text').toLocaleLowerCase();
                var txt2 = Cube.str.replace(Cube.str.clearUnicode(txt), ' ', '').toLocaleLowerCase();

                if(txt.split(text).length>1 || txt2.split(text2).length>1){
                    $(elem).show();
                    cc++;
                }else{
                    $(elem).hide();
                }
            });

            var checkGroup = function(group, callback){
                var s = false;
                var dropdownHeader = $(group).children('.dropdown-header');
                if(dropdownHeader.length){
                    var header_text = $(dropdownHeader[0]).html().toLocaleLowerCase();
                    var hcl = Cube.str.replace(Cube.str.clearUnicode(header_text), ' ', '');
                    if(header_text.split(text).length>1 || hcl.split(text2).length>1){
                        s = true;
                        $(group).find('.option-group').show();
                        $(group).find('.option-item').show();
                        
                    }
                }
                if(!s){
                    $(group).children().each(function(ind, elm){
                        if($(elm).hasClass('option-item')){
                            var item_text = $(elm).data('text').toLocaleLowerCase();
                            var itcl = Cube.str.replace(Cube.str.clearUnicode(item_text), ' ', '');
                            if(item_text.split(text).length>1 || itcl.split(text2).length>1){
                                s = true;
                                $(elm).show();
                            }else{
                                $(elm).hide();
                            }
                            
                        }else if($(elm).hasClass('option-group')){
                            var a = callback(elm, callback);
                            if(a) s = a;
                        }
                    });
                    
                }
                if(s){
                    $(group).show();
                }else{
                    $(group).hide();
                }
                return s;
            };

            $(this).find('.option-list>.option-group').each(function (index, elem) {
                if(checkGroup(elem, checkGroup)) cc++;
            });

            if(!cc){
                $(this).find('.message').show();
            }else{
                $(this).find('.message').hide();
            }
        }
    });

    $('.cube-select-group.ajax .dropdown-menu').on('keyup mouseup', function (e){
        var el = e.target;
        var tag = el.tagName.toLowerCase();
        if(tag=='input' && el.getAttribute('name') == 'search_options'){
            var s = el.value;
            let $select = $(this).parent().parent().parent();
            let method = $select.data('method');
            let url = $select.data('url');
            Cube.ajax(url,method, {s:s}, function (param) {
                
            })
        }
    });
});