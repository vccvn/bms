/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.tags = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},
    keywords: '',
    search_selector: '.input-search-tag',
    ls: ".with-live-search .live-search",
    data: {},
    init_list: ["urls", "templates", 'search_selector'],
    init: function(args) {
        if (!args || typeof args == 'undefined') return;
        for (var key in args) {
            var d = args[key];
            if (this.init_list.indexOf(key) >= 0) {
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
            } else {
                this.data[key] = d;
            }
        }
    },
    update: function(id) {
        custom_modal({
            title: "Cập nhật thẻ",
            content: this.templates.loading
        });
        $('#forn-animate-loading').removeClass('d-none');

        this.currentID = id;
        Cube.ajax(this.urls.get_tag_url, "GET", { id: id }, function(rs) {
            if (rs.status) {
                var tag = rs.tag;
                custom_modal({
                    title: "Cập nhật thẻ",
                    content: Cube.str.eval(this.templates.form + this.templates.message + this.templates.loading, { tag: tag.keywords, message: "thao tác thành công" }),
                    buttons: this.templates.buttons
                });
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },
    
    saveUpdate: function(id, tag) {
        $('#update-item-form, #update-item-message, .btn-back-to-form, .btn-submit-update').removeClass('d-none').addClass('d-none');
        $('#forn-animate-loading').removeClass('d-none');

        Cube.ajax(this.urls.update_url, "POST", { id: id, tag: tag }, function(rs) {
            if (rs.status) {
                var tag = rs.tag;
                var t = tag.keywords;
                $('#item-name-' + tag.id).html(t);
                $('#item-name-' + tag.id).data('name', t);
                modal_alert("Đã cập nhật thẻ thành công");
            } else {
                $('#update-item-form, #forn-animate-loading, .btn-submit-update').removeClass('d-none').addClass('d-none');
                $('#update-item-message, .btn-back-to-form').removeClass('d-none');
                $('#update-item-message-text').html(rs.error);
                $('#update-item-message-text').removeClass(['alert-success', 'alert-primary', 'alert-warning', 'alert-danger']).addClass('alert-warning');
            }
        }.bind(this));
    },
    showForm: function() {
        $('#update-item-message, .btn-back-to-form, #forn-animate-loading').removeClass('d-none').addClass('d-none');
        $('#update-item-form, .btn-submit-update').removeClass('d-none');

    },

    addtagFromSearch: function() {
        var tags = $(this.search_selector).val();

        if (tags) {
            Cube.ajax(this.urls.add_tag_url, "POST", { tags: tags }, function(rs) {
                if (rs.status && rs.data.length) {
                    this.hideLiveSearch();
                    $(this.search_selector).val('');
                    for (var tag of rs.data) {
                        this.addTagLink(tag.id, tag.keywords);
                    }
                } else {
                    modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            }.bind(this));
        } else {
            this.hideLiveSearch();
            this.showMessage("Bạn chưa nhập từ khóa")
        }
    },

    // foreign

    getTagIdList: function() {
        var list = [];
        var $list = $('.input-hidden-tags-group .input-tag-hidden');
        if ($list.length) {
            for (var i = 0; i < $list.length; i++) {
                list[list.length] = $($list[i]).val();
            }
        }
        return list;
    },
    checktaglink: function(id) {
        var list = this.getTagIdList();
        for (var i = 0; i < list.length; i++) {
            if (list[i] == id) return true;
        }
        return false;
    },

    hideLiveSearch: function() {
        $(this.ls + ', ' + this.ls + ' .result, ' + this.ls + ' .message, ' + this.ls + ' .actions').removeClass('d-none').addClass('d-none');
    },
    showLiveSearch: function() {
        $(this.ls).removeClass('d-none');
    },
    showAction: function() {
        this.showLiveSearch();
        if (this.keywords) {
            $(this.ls + ' .actions .add-tag span').html(this.keywords);
        }
        $(this.ls + ' .actions').removeClass('d-none');
    },

    addTagLink: function(id, keywords) {
        if (!this.checktaglink(id)) {
            $('.input-hidden-tags-group').append(Cube.str.eval(this.templates.hidden_input, { id: id }));
            if (!$('.tag-list ul.tag-list-body').length) {
                $('.tag-list').html(this.templates.link_list);
                $('.tag-list ul.tag-list-body').html('');
            }
            $('.tag-list ul.tag-list-body').append(Cube.str.eval(this.templates.link_item,{id:id,keywords:keywords}));
        }
        $('#tag-item-' + id).fadeOut(300, function() {
            $(this).remove();
        });
    },
    removeTagLink:function(id){
        cl(id);
        $('#tag-hidden-'+id).remove();
        $('#taglink-item-' + id).fadeOut(400, function(){
            $(this).remove();
        });
    },
    showResult: function(data) {
        this.hideLiveSearch();
        var rssl = this.ls + " .result .taglist";
        if (!$(rssl).length) {
            $(this.ls + " .result").append(this.templates.list);
        }
        $(rssl).html('');
        if (!data.length) {
            this.showLiveSearch();
            this.showMessage("không có kết quả phù hợp");
            if (this.keywords) {
                this.showAction();
            }
        } else {
            var tags = '';
            var items = '';
            var i = 0;
            var e = 0;
            var active_item = null;
            for (tag of data) {
                if (!this.checktaglink(tag.id)) {
                    items += Cube.str.eval(this.templates.item, tag);
                    i++;
                } else {
                    e++;
                }
                if (tag.keywords == this.keywords) {
                    active_item = true;
                }
            }
            if (i) {
                $(rssl).append(items);
                $(this.ls + ' .result').removeClass('d-none');
                this.showLiveSearch();
            } else if (e) {
                this.showMessage(e + " Thẻ đã có trong danh sách");
            }
            if (!active_item) this.showAction();

        }
    },
    hideResult: function() {
        $(this.ls + ' .result').addClass('d-none');
    },
    showMessage: function(message) {
        this.showLiveSearch();
        $(this.ls + ' .message').removeClass('d-none');
        $(this.ls + ' .message .message-text').html(message);
    },
    hideMessage: function() {
        $(this.ls + ' .message').removeClass('d-none').addClass('d-none');
    },
    liveSearch: function(keywords) {
        if (keywords.length < 1) {
            this.hideLiveSearch();
            return this.showMessage("Bạn chưa nhập thẻ");
        }
        this.keywords = keywords;
        Cube.ajax(this.urls.data_url, "GET", { keywords: keywords }, function(rs) {
            if (rs.status) {
                this.showResult(rs.data);
            } else {
                this.showMessage("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    }
};

$(function() {
    if (typeof window.tagsInit == 'function') {
        window.tagsInit();
        window.tagsInit = null;
    }

    //update

    $('.btn-update-item').click(function() {
        let id = $(this).data('id');
        Cube.tags.update(id);
        return false;
    });

    // save update
    $(document).on('click', '.btn-submit-update', function() {
        var tag = $('#input-tags').val();
        var id = Cube.tags.currentID;
        Cube.tags.saveUpdate(id, tag);
    });

    $(document).on('click', '.btn-back-to-form', function() {
        Cube.tags.showForm();
    });

    $('.input-search-tag').keyup(function() {
        Cube.tags.liveSearch($(this).val());
    });
    // $('.input-search-tag').change(function() {
    //     Cube.tags.liveSearch($(this).val());
    // });
    $('.btn-searct-tag').click(function() {
        Cube.tags.liveSearch($(this).parent().parent().children('.input-search-tag').val());
    });


    // them tag co san tu list tim kiem dc

    $(document).on('click', '.add-tag-item', function() {
        var id = $(this).data('id');
        var keywords = $(this).data('keywords');
        Cube.tags.addTagLink(id, keywords);
        return false;
    });

    // them tag co san tu list tim kiem dc

    $(document).on('click', '.btn-add-new-tags', function() {
        Cube.tags.addtagFromSearch();
        return false;
    });
    $('.tag-list').on('click','.btn-remove-taglink',function(){
        var id = $(this).data('id');
        Cube.tags.removeTagLink(id);
        return false;
    });
});