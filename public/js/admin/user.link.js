/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.user_link = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},
    keywords: '',
    search_selector: '.input-search-user',
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
    // foreign

    getUserIdList: function() {
        var list = [];
        var $list = $('.input-hidden-users-group .input-user-hidden');
        if ($list.length) {
            for (var i = 0; i < $list.length; i++) {
                list[list.length] = $($list[i]).val();
            }
        }
        return list;
    },
    checkUserlink: function(id) {
        var list = this.getUserIdList();
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
            $(this.ls + ' .actions .add-user span').html(this.keywords);
        }
        $(this.ls + ' .actions').removeClass('d-none');
    },

    addUserLink: function(id, name, email, username) {
        if (!this.checkUserlink(id)) {
            $('.input-hidden-users-group').append(Cube.str.eval(this.templates.hidden_input, { id: id }));
            if (!$('.user-list ul.user-list-body').length) {
                $('.user-list').html(this.templates.link_list);
                $('.user-list ul.user-list-body').html('');
            }
            $('.user-list ul.user-list-body').append(Cube.str.eval(this.templates.link_item,{
                id:id,
                name:name,
                email:email,
                username:username
            }));
        }
        $('#user-item-link-' + id).fadeOut(300, function() {
            $(this).remove();
        });
    },
    removeUserLink:function(id){
        $('#user-hidden-'+id).remove();
        $('#userlink-item-' + id).fadeOut(400, function(){
            $(this).remove();
        });
    },
    showResult: function(data) {
        this.hideLiveSearch();
        var rssl = this.ls + " .result .userlist";
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
            var items = '';
            var i = 0;
            var e = 0;
            var active_item = null;
            for (user of data) {
                if (!this.checkUserlink(user.id)) {
                    items += Cube.str.eval(this.templates.item, user);
                    i++;
                } else {
                    e++;
                }
                if (user.name == this.keywords || user.username == this.keywords || user.email == this.keywords) {
                    active_item = true;
                }
            }
            if (i) {
                $(rssl).append(items);
                $(this.ls + ' .result').removeClass('d-none');
                this.showLiveSearch();
            } else if (e) {
                this.showMessage(e + " thành viên đã có trong danh sách");
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
            return this.showMessage("Bạn chưa nhập từ khóa");
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
    if (typeof window.userLinksInit == 'function') {
        window.userLinksInit();
        window.userLinksInit = null;
    }

    $('.input-search-user').keyup(function() {
        Cube.user_link.liveSearch($(this).val());
    });
    // $('.input-search-user').change(function() {
    //     Cube.user_link.liveSearch($(this).val());
    // });
    $('.btn-search-user').click(function() {
        Cube.user_link.liveSearch($(this).parent().parent().children('.input-search-user').val());
    });


    // them user co san tu list tim kiem dc

    $(document).on('click', '.add-user-item', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var username = $(this).data('username');
        Cube.user_link.addUserLink(id, name, email, username);
        $(this).parent().remove();
        return false;
    });

    $('.user-list').on('click','.btn-remove-userlink',function(){
        var id = $(this).data('id');
        Cube.user_link.removeUserLink(id);
        return false;
    });

});