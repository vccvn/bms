/**
 * doi tuong phan quyen role
 * @type {Object}
 */
Cube.permissions = {
    urls: {},
    roles: [],
    current_role_id: 0,
    current_role_users: [],
    init: function(args) {
        this.roles = args.roles;
        this.urls = args.urls;
    },
    showListUser: function(tab, list) {
        var $tab = $('#modal-role-users li a[data-tab="' + tab + '"]');
        var slt = $tab.attr('href');
        var s = '';

        cl(slt);
        if (list.length < 1) {
            $(slt + ' .list-body').html('<div class="row"><div class="col-12 text-center">không có user nào</div></div>');

        } else {

            for (var i = 0; i < list.length; i++) {
                var user = list[i];
                s += '<div class="row" id="user-' + user.id + '">';
                s += '<div class="col-2 col-sm-2 col-md-1">';
                s += '<label class="cube-check"><input type="checkbox" name="check_item[]" class="check-item checkbox" value="' + user.id + '" data-user-id="' + user.id + '" ><span></span></label>';
                s += '</div>';
                s += '<div class="col-2 col-sm-2 col-md-1">';
                s += user.id;
                s += '</div>';
                s += '<div class="col-4 col-sm-4 col-md-5">';
                s += user.name;
                s += '</div>';
                s += '<div class="col-4 col-sm-4 col-md-5">';
                s += user.email;
                s += '</div>';
                s += '</div>';
            }
            $(slt + ' .list-body').html(s);
        }
        this.hideLoading('users');
        $(slt + ' .modal-list').removeClass('show').addClass('show');
    },

    getListUser: function(id, page) {
        if (typeof this.roles['role_' + id] != 'undefined') {
            var role = this.roles['role_' + id];
            this.current_role_id = role.id;
            $('#modal-role-user-name').html('Chi tiết quyền ' + role.name);
            this.showLoading('users');
            var $tab = $('#modal-role-users li a[data-toggle="tab"].active');
            var tab = $tab.data('tab');
            var slt = $tab.attr('href');
            var users = role.users[tab];
            var search = $(slt + ' .user-role-search input').val();
            if (search != users.search || users.list.length == 0 || page) {
                var pg = parseInt(page);
                var p = 1;
                if (!isNaN(pg)) {
                    p = pg;
                }
                this.roles['role_' + id].users[tab], page = p;
                this.roles['role_' + id].users[tab].search = search;
                var url = this.urls.get_list_user_not_in_role;
                if (tab == 'inrole') {
                    url = this.urls.get_list_user_in_role;
                }
                var data = {
                    id: role.id,
                    tab: tab,
                    search: search,
                    page: p
                };
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        cl(rs);
                        if (rs.status) {
                            var users = Cube.permissions.roles['role_' + rs.id].users[rs.tab];
                            users.list = rs.users;
                            users.total = rs.total;
                            Cube.permissions.roles['role_' + rs.id].users[rs.tab] = users;
                            Cube.permissions.showListUser(rs.tab, users.list);
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                    }
                });

            } else {
                Cube.permissions.showListUser(tab, users.list);
            }


        }

    },
    getMoreUser: function(id) {
        if (typeof this.roles['role_' + id] != 'undefined') {
            var role = this.roles['role_' + id];
            this.current_role_id = role.id;
            $('#modal-role-user-name').html('Chi tiết quyền ' + role.name);
            this.showLoading('users');
            var $tab = $('#modal-role-users li a[data-toggle="tab"].active');
            var tab = $tab.data('tab');
            var slt = $tab.attr('href');
            var users = role.users[tab];
            var search = $(slt + ' .user-role-search input').val();
            if (users.list.length < users.total) {
                this.roles['role_' + id].users[tab].search = search;
                var url = this.urls.get_list_user_not_in_role;
                if (tab == 'inrole') {
                    url = this.urls.get_list_user_in_role;
                }
                var data = {
                    id: role.id,
                    tab: tab,
                    search: search,
                    page: users.page + 1
                };
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        if (rs.status) {
                            var users = Cube.permissions.roles['role_' + rs.id].users[rs.tab];
                            for (var i = 0; i < rs.users.length; i++) {
                                users.list[users.list.length] = rs.users[i];
                            }
                            users.total = rs.total;
                            users.page += 1;
                            Cube.permissions.roles['role_' + rs.id].users[rs.tab] = users;
                            Cube.permissions.showListUser(rs.tab, users.list);
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                    }
                });

            } else {
                Cube.permissions.showListUser(tab, users.list);
            }


        }

    },
    addUser: function() {
        var $tab = $('#modal-role-users li a[data-toggle="tab"].active');
        var tab = $tab.data('tab');
        var slt = $tab.attr('href');

        var list = $(slt + ' .list-body input[type="checkbox"].check-item:checked');
        if (list.length > 0) {
            // xac nhan thay doi

            modal_confirm("bạn có chắc chắn muốn cấp quyền cho " + (list.length > 1 ? list.length : '') + " người này?", function(stt) {
                if (stt) {
                    showModal('modal-role-users');
                    Cube.permissions.showLoading('users');
                    var users = [];
                    for (var i = 0; i < list.length; i++) {
                        var $item = $(list[i]);
                        //var val = $item.val();
                        var id = $item.data('user-id');
                        users[users.length] = id;
                    }
                    var data = { role_id: Cube.permissions.current_role_id, users: users };
                    var url = Cube.permissions.urls.add_users_role;
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: 'JSON',
                        cookie: true,
                        success: function(rs) {
                            Cube.permissions.hideLoading('users');
                            if (rs.status) {
                                if (rs.remove_list) {
                                    var users = Cube.permissions.roles['role_' + rs.id].users.notinrole.list;
                                    var rl = rs.remove_list;
                                    var ul = {};
                                    var list = [];
                                    for (var i = 0; i < rl.length; i++) {
                                        ul[rl[i]] = true;
                                    }
                                    for (var i = 0; i < users.length; i++) {
                                        var user = users[i];
                                        var uid = user.id;
                                        if (ul[uid] == true) {
                                            $('.modal .list-body #user-' + uid).hide(400, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            list[list.length] = users[i];
                                        }

                                    }
                                    Cube.permissions.roles['role_' + rs.id].users.notinrole.list = list;
                                    Cube.permissions.showListUser('notinrole', list);

                                }
                                Cube.permissions.roles['role_' + rs.id].users.notinrole.total = rs.total;
                            } else {
                                modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            }
                        },
                        error: function(e) {
                            Cube.permissions.hideLoading('users');
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            setTimeout(function() {
                                showModal('modal-role-users');
                            }, 2000);
                        }
                    });
                } else {
                    showModal('modal-role-users');
                }
            });
        }

    },
    removeUser: function() {
        var $tab = $('#modal-role-users li a[data-toggle="tab"].active');
        var tab = $tab.data('tab');
        var slt = $tab.attr('href');

        var list = $(slt + ' .list-body input[type="checkbox"].check-item:checked');
        if (list.length > 0) {
            // xac nhan thay doi

            modal_confirm("bạn có chắc chắn muốn loại bỏ quyền của " + list.length + " người này?", function(stt) {
                if (stt) {
                    showModal('modal-role-users');
                    Cube.permissions.showLoading('users');
                    var users = [];
                    for (var i = 0; i < list.length; i++) {
                        var $item = $(list[i]);
                        //var val = $item.val();
                        var id = $item.data('user-id');
                        users[users.length] = id;
                    }
                    var data = { role_id: Cube.permissions.current_role_id, users: users };
                    var url = Cube.permissions.urls.remove_users_role;
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: 'JSON',
                        cookie: true,
                        success: function(rs) {
                            Cube.permissions.hideLoading('users');
                            if (rs.status) {
                                if (rs.remove_list) {
                                    var users = Cube.permissions.roles['role_' + rs.id].users.inrole.list;
                                    var rl = rs.remove_list;
                                    var ul = {};
                                    var list = [];
                                    for (var i = 0; i < rl.length; i++) {
                                        ul[rl[i]] = true;
                                    }
                                    for (var i = 0; i < users.length; i++) {
                                        var user = users[i];
                                        var uid = user.id;
                                        if (ul[uid] == true) {
                                            $('.modal .list-body #user-' + uid).hide(400, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            list[list.length] = users[i];
                                        }

                                    }
                                    Cube.permissions.roles['role_' + rs.id].users.inrole.list = list;
                                    Cube.permissions.showListUser('inrole', list);

                                }
                                Cube.permissions.roles['role_' + rs.id].users.inrole.total = rs.total;
                            } else {
                                modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            }
                        },
                        error: function(e) {
                            Cube.permissions.hideLoading('users');
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            setTimeout(function() {
                                showModal('modal-role-users');
                            }, 2000);
                        }
                    });
                } else {
                    showModal('modal-role-users');
                }
            });
        }

    },



    showListModule: function(tab, list) {
        var $tab = $('#modal-role-modules li a[data-tab="' + tab + '"]');
        var slt = $tab.attr('href');
        var s = '';

        if (list.length < 1) {
            $(slt + ' .list-body').html('<div class="row"><div class="col-12 text-center">không có module nào</div></div>');

        } else {

            for (var i = 0; i < list.length; i++) {
                var mod = list[i];
                s += '<div class="row" id="module-' + mod.id + '">';
                s += '<div class="col-2 col-sm-2 col-md-1">';
                s += '<label class="cube-check"><input type="checkbox" name="check_item[]" class="check-item checkbox" value="' + mod.id + '" data-module-id="' + mod.id + '" ><span></span></label>';
                s += '</div>';
                s += '<div class="col-2 col-sm-2 col-md-1">';
                s += mod.id;
                s += '</div>';
                s += '<div class="col-8 col-sm-8 col-md-10">';
                s += mod.name;
                s += '</div>';
                s += '</div>';
            }
            $(slt + ' .list-body').html(s);
        }
        this.hideLoading('modules');
        $(slt + ' .modal-list').removeClass('show').addClass('show');
    },

    getListModule: function(id, page) {
        if (typeof this.roles['role_' + id] != 'undefined') {
            var role = this.roles['role_' + id];
            this.current_role_id = role.id;
            $('#modal-role-module-name').html('Chi tiết quyền ' + role.name);
            this.showLoading('modules');
            var $tab = $('#modal-role-modules li a[data-toggle="tab"].active');
            var tab = $tab.data('tab');
            var slt = $tab.attr('href');
            var modules = role.modules[tab];
            var search = $(slt + ' .module-role-search input').val();
            if (search != modules.search || modules.list.length == 0 || page) {
                var pg = parseInt(page);
                var p = 1;
                if (!isNaN(pg)) {
                    p = pg;
                }
                this.roles['role_' + id].modules[tab], page = p;
                this.roles['role_' + id].modules[tab].search = search;
                var url = this.urls.get_list_module_not_required_role;
                if (tab == 'required') {
                    url = this.urls.get_list_module_required_role;
                }
                var data = {
                    id: role.id,
                    tab: tab,
                    search: search,
                    page: p
                };
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        if (rs.status) {
                            var modules = Cube.permissions.roles['role_' + rs.id].modules[rs.tab];
                            modules.list = rs.modules;
                            modules.total = rs.total;
                            Cube.permissions.roles['role_' + rs.id].modules[rs.tab] = modules;
                            Cube.permissions.showListModule(rs.tab, modules.list);
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                    }
                });

            } else {
                Cube.permissions.showListModule(tab, modules.list);
            }


        }

    },
    getMoreModule: function(id) {
        if (typeof this.roles['role_' + id] != 'undefined') {
            var role = this.roles['role_' + id];
            this.current_role_id = role.id;
            $('#modal-role-module-name').html('Chi tiết quyền ' + role.name);
            this.showLoading('modules');
            var $tab = $('#modal-role-modules li a[data-toggle="tab"].active');
            var tab = $tab.data('tab');
            var slt = $tab.attr('href');
            var modules = role.modules[tab];
            var search = $(slt + ' .module-role-search input').val();
            if (modules.list.length < modules.total) {
                this.roles['role_' + id].modules[tab].search = search;
                var url = this.urls.get_list_module_not_required_role;
                if (tab == 'required') {
                    url = this.urls.get_list_module_required_role;
                }
                var data = {
                    id: role.id,
                    tab: tab,
                    search: search,
                    page: modules.page + 1
                };
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        if (rs.status) {
                            var modules = Cube.permissions.modules['role_' + rs.id].modules[rs.tab];
                            for (var i = 0; i < rs.modules.length; i++) {
                                modules.list[modules.list.length] = rs.modules[i];
                            }
                            modules.total = rs.total;
                            modules.page += 1;
                            Cube.permissions.roles['role_' + rs.id].modules[rs.tab] = modules;
                            Cube.permissions.showListModule(rs.tab, modules.list);
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                    }
                });

            } else {
                Cube.permissions.showListModule(tab, modules.list);
            }


        }

    },
    addModule: function() {
        var $tab = $('#modal-role-modules li a[data-toggle="tab"].active');
        var tab = $tab.data('tab');
        var slt = $tab.attr('href');

        var list = $(slt + ' .list-body input[type="checkbox"].check-item:checked');
        if (list.length > 0) {
            // xac nhan thay doi

            modal_confirm("bạn có chắc chắn muốn cấp quyền cho " + (list.length > 1 ? list.length : '') + " module này?", function(stt) {
                if (stt) {
                    showModal('modal-role-modules');
                    Cube.permissions.showLoading('modules');
                    var modules = [];
                    for (var i = 0; i < list.length; i++) {
                        var $item = $(list[i]);
                        //var val = $item.val();
                        var id = $item.data('module-id');
                        modules[modules.length] = id;
                    }
                    var data = { role_id: Cube.permissions.current_role_id, modules: modules };
                    var url = Cube.permissions.urls.add_modules_role;
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: 'JSON',
                        cookie: true,
                        success: function(rs) {
                            Cube.permissions.hideLoading('modules');
                            if (rs.status) {
                                if (rs.remove_list) {
                                    var modules = Cube.permissions.roles['role_' + rs.id].modules.notrequired.list;
                                    var rl = rs.remove_list;
                                    var ul = {};
                                    var list = [];
                                    for (var i = 0; i < rl.length; i++) {
                                        ul[rl[i]] = true;
                                    }
                                    for (var i = 0; i < modules.length; i++) {
                                        var mod = modules[i];
                                        var uid = mod.id;
                                        if (ul[uid] == true) {
                                            $('.modal .list-body #module-' + uid).hide(400, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            list[list.length] = modules[i];
                                        }

                                    }
                                    Cube.permissions.roles['role_' + rs.id].modules.notrequired.list = list;
                                    Cube.permissions.showListModule('required', list);

                                }
                                Cube.permissions.roles['role_' + rs.id].modules.notrequired.total = rs.total;
                            } else {
                                modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            }
                        },
                        error: function(e) {
                            Cube.permissions.hideLoading('modules');
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            setTimeout(function() {
                                showModal('modal-role-modules');
                            }, 2000);
                        }
                    });
                } else {
                    showModal('modal-role-modules');
                }
            });
        }

    },
    removeModule: function() {
        var $tab = $('#modal-role-modules li a[data-toggle="tab"].active');
        var tab = $tab.data('tab');
        var slt = $tab.attr('href');

        var list = $(slt + ' .list-body input[type="checkbox"].check-item:checked');
        if (list.length > 0) {
            // xac nhan thay doi

            modal_confirm("bạn có chắc chắn muốn loại bỏ quyền của " + list.length + " module này?", function(stt) {
                if (stt) {
                    showModal('modal-role-modules');
                    Cube.permissions.showLoading('modules');
                    var modules = [];
                    for (var i = 0; i < list.length; i++) {
                        var $item = $(list[i]);
                        //var val = $item.val();
                        var id = $item.data('module-id');
                        modules[modules.length] = id;
                    }
                    var data = { role_id: Cube.permissions.current_role_id, modules: modules };
                    var url = Cube.permissions.urls.remove_modules_role;
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: 'JSON',
                        cookie: true,
                        success: function(rs) {
                            Cube.permissions.hideLoading('modules');
                            if (rs.status) {
                                if (rs.remove_list) {
                                    var modules = Cube.permissions.roles['role_' + rs.id].modules.required.list;
                                    var rl = rs.remove_list;
                                    var ul = {};
                                    var list = [];
                                    for (var i = 0; i < rl.length; i++) {
                                        ul[rl[i]] = true;
                                    }
                                    for (var i = 0; i < modules.length; i++) {
                                        var mod = modules[i];
                                        var mid = mod.id;
                                        if (ul[mid] == true) {
                                            $('.modal .list-body #module-' + mid).hide(400, function() {
                                                $(this).remove();
                                            });
                                        } else {
                                            list[list.length] = mod;
                                        }

                                    }
                                    Cube.permissions.roles['role_' + rs.id].modules.required.list = list;
                                    Cube.permissions.showListModule('required', list);

                                }
                                Cube.permissions.roles['role_' + rs.id].modules.required.total = rs.total;
                            } else {
                                modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            }
                        },
                        error: function(e) {
                            Cube.permissions.hideLoading('modules');
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                            setTimeout(function() {
                                showModal('modal-role-modules');
                            }, 2000);
                        }
                    });
                } else {
                    showModal('modal-role-modules');
                }
            });
        }

    },



    showLoading: function(appfix) {
        $('#modal-role-' + appfix + ' .modal-list').removeClass('show');
        $('#modal-role-' + appfix + ' .loading').addClass('show');

    },
    hideLoading: function(appfix) {
        $('#modal-role-' + appfix + ' .loading').removeClass('show');
        $('#modal-role-' + appfix + ' .modal-list').removeClass('show').addClass('show');
    },
}




$(function() {
    if (typeof window.permissionsInit == 'function') {
        window.permissionsInit();
        window.permissionsInit = null;
    }

    $('.btn-view-role-user-list').click(function() {
        return false;
    });

    $('.btn-view-user-has-role').click(function() {
        var id = $(this).data('id');
        showModal('modal-role-users');
        Cube.permissions.getListUser(id);
        return false;
    });

    $('#modal-role-users .user-role-search').submit(() => {
        //
        Cube.permissions.getListUser(Cube.permissions.current_role_id);
        return false;
    });

    $('#modal-role-users .btn-refresh-role-user').click(() => {
        //
        Cube.permissions.getListUser(Cube.permissions.current_role_id, true);
        return false;
    });

    $('.btn-remove-role-user').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.removeUser();
        return false;
    });

    $('.btn-seemore-role-user').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.getMoreUser(Cube.permissions.current_role_id);
        return false;
    });

    $('.btn-add-role-user').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.addUser();
        return false;
    });



    $('#modal-role-users a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        // var target = $(e.target).attr("href") // activated tab
        // //alert(target);
        // cl(target);

        setTimeout(function() {

            Cube.permissions.getListUser(Cube.permissions.current_role_id);
        }, 100);
    });





    $('.btn-view-role-module-list').click(function() {
        return false;
    });

    $('.btn-view-module-require-role').click(function() {
        var id = $(this).data('id');

        showModal('modal-role-modules');
        Cube.permissions.getListModule(id);
        return false;
    });

    $('#modal-role-modules .module-role-search').submit(function() {
        //
        Cube.permissions.getListModule(Cube.permissions.current_role_id);
        return false;
    });

    $('#modal-role-modules .btn-refresh-role-module').click(function() {
        //
        Cube.permissions.getListModule(Cube.permissions.current_role_id, true);
        return false;
    });

    $('.btn-remove-role-module').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.removeModule();
        return false;
    });

    $('.btn-seemore-role-module').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.getMoreModule(Cube.permissions.current_role_id);
        return false;
    });

    $('.btn-add-role-module').click(function() {
        //var id = $(this).data('role-id');
        Cube.permissions.addModule();
        return false;
    });



    $('#modal-role-modules a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        setTimeout(function() {
            Cube.permissions.getListModule(Cube.permissions.current_role_id);
        }, 100);
    });



    $('.btn-delete-role').click(function() {
        var id = $(this).data('id');

        Cube.permissions.current_role_id = id;
        modal_confirm('Bạn có chắc chắn muốn xóa quyền này?', function(s) {
            if (s) {
                $.ajax({
                    type: "POST",
                    url: Cube.permissions.urls.delete_role_url,
                    data: { id: Cube.permissions.current_role_id },
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        if (rs.status) {
                            modal_alert('Đã xóa quyền thành công!');
                            $('#role-item-' + Cube.permissions.current_role_id).hide(400, function() {
                                $(this).remove();
                            });
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');

                    }
                });
            }
        });

        return false;
    });

    $('.btn-delete-module').click(function() {
        var id = $(this).data('id');
        Cube.permissions.module_id = id;
        modal_confirm('Bạn có chắc chắn muốn xóa module này?', function(s) {
            if (s) {
                $.ajax({
                    type: "POST",
                    url: Cube.permissions.urls.ajax_delete,
                    data: { id: Cube.permissions.module_id },
                    dataType: 'JSON',
                    cookie: true,
                    success: function(rs) {
                        if (rs.status) {
                            modal_alert('Đã xóa module thành công!');
                            $('#module-item-' + rs.id).hide(400, function() {
                                $(this).remove();
                            });
                        } else {
                            modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                        }
                    },
                    error: function(e) {
                        modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');

                    }
                });
            }
        });

        return false;
    });

    $('.btn-save-module-role').click(function() {
        var list = $('.role-list input[type="checkbox"].check-item:checked');
        var data = {};
        var mod = {};
        if (list.length > 0) {
            for (var i = 0; i < list.length; i++) {
                var $item = $(list[i]);
                var $val = $item.val();
                var id = $item.data('module-id');
                if (mod[id] == undefined) {
                    mod[id] = [$val];
                } else {
                    mod[id][mod[id].length] = $val
                }
            }
        }
        data['modules'] = modules;
        data['roles'] = mod;
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            dataType: 'JSON',
            cookie: true,
            success: function(rs) {
                if (rs.status) {
                    modal_alert('Đã cập nhật quyền thành công');
                } else {
                    modal_alert('Lỗi bất ngờ! Vui lòng thử lại sau giây lát');
                }
            },
            error: function(e) {
                cl(e);
            }
        });
        return false;
    });
});