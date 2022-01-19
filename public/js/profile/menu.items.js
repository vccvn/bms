/**
 * doi tuong quan li item
 * @type {Object}
 */
Cube.menuItems = {
    currentID: 0,
    listID: [],
    urls: {},
    templates: {},
    keywords: '',
    data: {},
    menu_id:0,
    init_list: ["urls", "templates", 'menu_id'],
    flis: [
        // 0          1        2        3        4         5        6            7
        'title2', 'link_type', 'url', 'route', 'action', 'param', 'cate_id', 'product_cate_id',
        //  8            9            10           11               12                13          14
        'sub_type', 'sub_action', 'sub_param', 'sub_cate_id', 'sub_product_cate_id', 'sub_file', 'sub_menu_id',
        // 15          16
        'page_id', 'sub_page_id'
    ],
    icons: ["none", "adjust", "anchor", "archive", "arrows", "arrows-h", "arrows-v", "asterisk", "ban", "bar-chart-o", "barcode", "bars", "beer", "bell", "bell-o", "bolt", "book", "bookmark", "bookmark-o", "briefcase", "bug", "building-o", "bullhorn", "bullseye", "calendar", "calendar-o", "camera", "camera-retro", "caret-square-o-down", "caret-square-o-left", "caret-square-o-right", "caret-square-o-up", "certificate", "check", "check-circle", "check-circle-o", "check-square", "check-square-o", "circle", "circle-o", "clock-o", "cloud", "cloud-download", "cloud-upload", "code", "code-fork", "coffee", "cog", "cogs", "comment", "comment-o", "comments", "comments-o", "compass", "credit-card", "crop", "crosshairs", "cutlery", "desktop", "dot-circle-o", "download", "ellipsis-h", "ellipsis-v", "envelope", "envelope-o", "eraser", "exchange", "exclamation", "exclamation-circle", "exclamation-triangle", "external-link", "external-link-square", "eye", "eye-slash", "female", "fighter-jet", "film", "filter", "fire", "fire-extinguisher", "flag", "flag-checkered", "flag-o", "flask", "folder", "folder-o", "folder-open", "folder-open-o", "frown-o", "gamepad", "gavel", "gift", "glass", "globe", "hdd-o", "headphones", "heart", "heart-o", "home", "inbox", "info", "info-circle", "key", "keyboard-o", "laptop", "leaf", "lemon-o", "level-down", "level-up", "lightbulb-o", "location-arrow", "lock", "magic", "magnet", "mail-reply-all", "male", "map-marker", "meh-o", "microphone", "microphone-slash", "minus", "minus-circle", "minus-square", "minus-square-o", "mobile", "money", "moon-o", "music", "pencil", "pencil-square", "pencil-square-o", "phone", "phone-square", "picture-o", "plane", "plus", "plus-circle", "plus-square", "plus-square-o", "power-off", "print", "puzzle-piece", "qrcode", "question", "question-circle", "quote-left", "quote-right", "random", "refresh", "reply", "reply-all", "retweet", "road", "rocket", "rss", "rss-square", "search", "search-minus", "search-plus", "share", "share-square", "share-square-o", "shield", "shopping-cart", "sign-in", "sign-out", "signal", "sitemap", "smile-o", "sort", "sort-alpha-asc", "sort-alpha-desc", "sort-amount-asc", "sort-amount-desc", "sort-asc", "sort-desc", "sort-numeric-asc", "sort-numeric-desc", "spinner", "square", "square-o", "star", "star-half", "star-half-o", "star-o", "subscript", "suitcase", "sun-o", "superscript", "tablet", "tachometer", "tag", "tags", "tasks", "terminal", "thumb-tack", "thumbs-down", "thumbs-o-down", "thumbs-o-up", "thumbs-up", "ticket", "times", "times-circle", "times-circle-o", "tint", "trash-o", "trophy", "truck", "umbrella", "unlock", "unlock-alt", "upload", "user", "users", "video-camera", "volume-down", "volume-off", "volume-up", "wheelchair", "wrench", "btc", "eur", "gbp", "inr", "jpy", "krw", "rub", "try", "usd", "align-center", "align-justify", "align-left", "align-right", "bold", "chain-broken", "clipboard", "columns", "file", "file-o", "file-text", "file-text-o", "files-o", "floppy-o", "font", "indent", "italic", "link", "list", "list-alt", "list-ol", "list-ul", "outdent", "paperclip", "repeat", "scissors", "strikethrough", "table", "text-height", "text-width", "th", "th-large", "th-list", "underline", "undo", "angle-double-down", "angle-double-left", "angle-double-right", "angle-double-up", "angle-down", "angle-left", "angle-right", "angle-up", "arrow-circle-down", "arrow-circle-left", "arrow-circle-o-down", "arrow-circle-o-left", "arrow-circle-o-right", "arrow-circle-o-up", "arrow-circle-right", "arrow-circle-up", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "arrows-alt", "caret-down", "caret-left", "caret-right", "caret-up", "chevron-circle-down", "chevron-circle-left", "chevron-circle-right", "chevron-circle-up", "chevron-down", "chevron-left", "chevron-right", "chevron-up", "hand-o-down", "hand-o-left", "hand-o-right", "hand-o-up", "long-arrow-down", "long-arrow-left", "long-arrow-right", "long-arrow-up", "backward", "compress", "eject", "expand", "fast-backward", "fast-forward", "forward", "pause", "play", "play-circle", "play-circle-o", "step-backward", "step-forward", "stop", "youtube-play", "adn", "android", "apple", "bitbucket", "bitbucket-square", "css3", "dribbble", "dropbox", "facebook", "facebook-square", "flickr", "foursquare", "github", "github-alt", "github-square", "gittip", "google-plus", "google-plus-square", "html5", "instagram", "linkedin", "linkedin-square", "linux", "maxcdn", "pagelines", "pinterest", "pinterest-square", "renren", "skype", "stack-exchange", "stack-overflow", "trello", "tumblr", "tumblr-square", "twitter", "twitter-square", "vimeo-square", "vk", "weibo", "windows", "xing", "xing-square", "youtube", "youtube-square", "ambulance", "h-square", "hospital-o", "medkit", "stethoscope", "user-md"],
    currentIcon:null,
    iconRendered: false,
    action_type : 'add',
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

    sortItems:function(items){
        Cube.ajax(this.urls.sort_url, "POST", { items:items }, function(rs) {
            if (rs.status) {
                //cl(rs.items);
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },

    showEditForm:function(id){
        if(this.currentID == id) return showModal('update-item-modal');
        this.listID[this.listID.length] = id;
        Cube.ajax(this.urls.form_url, "GET", { id:id,menu_id:this.menu_id }, function(rs) {
            if (rs.status) {
                cl(rs.item);
                if(rs.form){
                    $('#update-item-title').html($('#item-name-' + id).data('name'));
                    $('#update-item-modal-content').html(rs.form);
                    Cube.menuItems.iconPicker('#update-item-modal-content input.input-icon');
                    showModal('update-item-modal');
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    },

    hideEditForm:function(id){
        hideModal('update-item-modal');
        
    },

    checkType: function() {
        var t = $('select#type').val();
        var dnone = [];
        var dblock = [];
        var fm = 'form-group-';
        var ctl = false;
        if (t == 'default') {
            ctl = true;
            dblock = ['title', 'link_type', 'sub_type'];
        } else if (t == 'category') {
            dblock = ['cate_id', 'sub_type'];
        } else if (t == 'product_category') {
            dblock = ['product_cate_id', 'sub_type'];
        } else if (t == 'page') {
            dblock = ['page_id', 'sub_type'];
        } else {
            dblock = ['action', 'param', 'sub_type'];
        }
        for (var i = 0; i < this.flis.length; i++) {
            $('#' + fm + this.flis[i]).removeClass('d-none').addClass('d-none');

        }
        for (var i = 0; i < dblock.length; i++) {
            $('#' + fm + dblock[i]).removeClass('d-none');
        }
        if (ctl) {
            this.checkSubType();
            this.checkLinkType();
        }
    },

    checkLinkType: function() {
        var t = $('select#link_type').val();
        var fm = 'form-group-';
        if (t == 'url') {
            $('#' + fm + this.flis[3]).removeClass('d-none').addClass('d-none');
            $('#' + fm + this.flis[5]).removeClass('d-none').addClass('d-none');
            $('#' + fm + this.flis[2]).removeClass('d-none');
        } else {
            $('#' + fm + this.flis[3]).removeClass('d-none');
            $('#' + fm + this.flis[5]).removeClass('d-none');
            $('#' + fm + this.flis[2]).removeClass('d-none').addClass('d-none');
        }
    },

    checkSubType: function() {
        var t = $('select#sub_type').val();
        var fm = 'form-group-';
        var slis = ['sub_action', 'sub_param', 'sub_cate_id', 'sub_post_cate_id', 'sub_menu_id', 'sub_file'];
        var dnone = [];
        var dblock = [];
        var b = {
            "none": "Không dùng sub menu",
            "defaulte": "theo loại item",
            "menu": "Trong bảng menu",
            "category": "Sự dụng Danh mục",
            "post_category": "Sự dụng chủ đề",
            "json": "Sự dụng file JSON",
            "define": "Tự định nghĩa"
        };
        if (t == 'menu') {
            dblock = ['sub_menu_id'];
        } else if (t == 'category') {
            dblock = ['sub_cate_id'];
        } else if (t == 'post_category') {
            dblock = ['sub_post_cate_id'];
        } else if (t == 'page') {
            dblock = ['sub_page_id'];
        } else if (t == 'json') {
            dblock = ['sub_file'];
        } else if (t == 'define') {
            dblock = ['sub_action', 'sub_param'];
        }
        for (var i = 0; i < slis.length; i++) {
            $('#' + fm + slis[i]).removeClass('d-none').addClass('d-none');

        }
        for (var i = 0; i < dblock.length; i++) {
            $('#' + fm + dblock[i]).removeClass('d-none');
        }

    },

    iconPicker: function(selector) {
        var $icoInp = $(selector);
        $icoInp.attr('type', 'hidden');
        var icon = $icoInp.val();
        var btn = '<button type="button" class="btn btn-secondary btn-sm choose-item-icon dropdown-toggle"><i class="fa fa-' + icon + '"></i> <span>' + (icon != "none" ? icon : "không") + '</span></button>';
        $icoInp.before(btn);
    },

    showIcons: function(el, callback) {
        //
        
        this.currentIcon = el;
        if (!this.iconRendered) {
            var html = '';
            html += '<div class="row list-icon">';
            for (var i = 0; i < this.icons.length; i++) {
                var icon = this.icons[i];
                html += '<div class="col-6 col-sm-4 col-lg-3 pb-2">';
                html += '<a href="#' + icon + '" class="d-block select-icon" data-icon="' + icon + '">';
                html += '<i class="fa fa-' + icon + '"></i> <span>' + (icon != "none" ? icon : "không") + '</span>';
                html += '</a>';
                html += '</div>';
            }
            html += '</div>';
            $('#custom-modal .custom-modal-content').html(html);
            $('#custom-modal .modal-title').html('Chọn biểu tượng cho item');
            $('#custom-modal .modal-dialog').addClass('modal-lg');
            this.iconRendered = true;
        }
        showModal('custom-modal', callback);
    },
    hideIcons: function() {
        hideModal('custom-modal');
    },

    /**
     * luu uteem
     * @param {object} data du lieu 
     */
    
    save:function(data){
        Cube.ajax(this.urls.save_url,'POST',data,function(rs){
            if(rs.status){
                if(this.action_type == 'update'){
                    $('#item-name-' + rs.item.id).html(rs.item.title);
                }else{
                    location.reload();
                }
            }else{
                if(rs.errors){
                    var msg = '';
                    for(var err of rs.errors){
                        msg+=err+"<br>";
                    }
                    if(this.action_type == 'update'){
                        modal_alert(msg,function(){
                            setTimeout(function(){
                                modal_hide_callback = function(){
                                    showModal('update-item-modal');
                                };
                            }, 300);
                        });
                    }else{
                        modal_alert(msg);
                    }
                }
            }
        }.bind(this));
    }
};

$(function(){
    if (typeof window.menuItemsInit == 'function') {
        window.menuItemsInit();
        window.menuItemsInit = null;
    }

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target);
        Cube.menuItems.sortItems(list.nestable('serialize'));
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
        maxDepth: 2
    })
    .on('change', updateOutput);
    

    
    //Cube.menuItems.iconPicker('.item-form-list .input-icon');
    $(document).on('click', '#update-item-modal .choose-item-icon', function() {
        Cube.menuItems.showIcons($(this),function(){
            setTimeout(function(){
                modal_hide_callback = function(){
                    showModal('update-item-modal');
                };
            }, 500);
        });
        
    });
    
    $(document).on('click', '.list-icon .select-icon', function() {
        var icon = $(this).data('icon');
        var $btn = $(Cube.menuItems.currentIcon);
        var $ifa = $btn.find(' i.fa');
        $ifa.removeClass();
        $ifa.addClass('fa fa-' + icon);
        $btn.find('span').html(icon);
        $btn.parent().find('.input-icon').val((icon != "none" ? icon : ""));
        hideModal();
        return false;
    });
    $(document).on('click', '.btn-hide-update-item-form', function() {
        var id = $(this).data('id');
        Cube.menuItems.hideEditForm(id);
        return false;
    });

    

    // change priority
    $(document).on('click', '.item-priority-select .priority-select a', function() {
        var id = $(this).data('id');
        var priority = $(this).data('priority');
        Cube.menuItems.changePriority(id, priority);
    });

    if($('.item-form-list').length){
        $(document).on('click', '.item-form-list .form-list-item a.nav-item', function(){
            var $li = $(this).parent();
            $li.siblings().removeClass('active');
            $li.toggleClass('active');
            return false;
        });
        Cube.menuItems.iconPicker('.item-form-list .input-icon');
        $(document).on('click', '.item-form-list .choose-item-icon', function() {
            Cube.menuItems.showIcons($(this));
        });
        $('.btn-edit-item').click(function(){
            var id = $(this).data('id');
            Cube.menuItems.showEditForm(id);
            return false;
        });
        $('.menu-item-form').submit(function(){
            var required_inputs = {
                page:['page_id','active_key'],
                category:['cate_id','active_key'],
                product_category:["product_cate_id",'active_key'],
                define:["title","action",'active_key'],
                route:['title','route','active_key'],
                default:["title",'url','active_key'],
                
            };
            var labels = {
                title:"Tiêu đề",
                active_key:"mã kích hoạt",
                cate_id: "Danh mục",
                product_cate_id: "Danh mục sản phẩm",
                page_id: "Mục",
                action: "phuong thức",
                route: "Route",
                param: "Tham số",
                url:'Đường dẫn'
            };
            var data = {};
            var inputs = $(this).find('.item-inp');
            var alert_message = '';
            if(inputs.length){
                for(var i = 0; i < inputs.length; i++){
                    var $inp = $(inputs[i]);
                    data[$inp.attr('name')] = $inp.val();
                }
            }
            if(data && data.type){
                if(typeof required_inputs[data.type] != 'undefined'){
                    //
                    for(var k = 0; k < required_inputs[data.type].length; k++){
                        var key = required_inputs[data.type][k];
                        if(typeof data[key] != 'undefined'){
                            
                            var val = data[key];
                            if(!val || val == "0" || val == 0){
                                alert_message+=labels[key]+" Không hợp lệ! <br>";
                                cl(data.type);
                                cl(key);
                                
                            }
                        }else{
                            alert_message+="Thiếu thông tin "+labels[key]+" hoặc thông tin "+labels[key]+" Không hợp lệ! <br>";
                        }
                    }
                }else{
                    alert_message+="Lỗi không xác định. vui lòng tải lại trang và thử lại <br>";
                }
            }
            if(alert_message){
                var action_type = 'add';
                if($(this).hasClass('update')){
                    action_type = 'update';
                    modal_alert(alert_message,function(){
                        setTimeout(function(){
                            if(last_modal_open == 'update-item-modal'){
                                modal_hide_callback = function(){
                                    showModal('update-item-modal');
                                };
                            }
                        }, 500);
                    });
                }else{
                    modal_alert(alert_message);
                }
            }
            else{
                Cube.menuItems.save(data, action_type);

            }
            return false;
        });

    }
    

    if ($('#item-form').length) {
        var fs = '#item-form';
        Cube.menuItems.checkType();
        Cube.menuItems.iconPicker('#item-form input#icon');

        $(document).on('change', 'select#type', function() {
            Cube.menuItems.checkType();
        });
        $(document).on('change', 'select#link_type', function() {
            Cube.menuItems.checkLinkType();
        });

        $(document).on('change', 'select#sub_type', function() {
            Cube.menuItems.checkSubType();
        });


        $(document).on('click', fs + ' .choose-item-icon', function() {
            Cube.menuItems.showIcons($(this));
        });

    }
});