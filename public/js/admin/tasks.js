/**
 * 
 * @type {Object}
 */
Cube.tasks = {
    currentID: 0,
    listID: [],
    urls: {},
    init_list: ["urls", "templates"],
    status_list: { "1": "Bật", "0": "Tắt" },
    status_color_types: {"0": "secondary", "1": "primary"},
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
    getBtnColor: function(status) {
        if (status) {
            if (typeof this.status_color_types[status] != 'undefined') {
                return this.status_color_types[status];
            }
        }
        return 'secondary';
    },
    delete: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn xóa " + (ids.length > 1 ? ids.length + " Task" : "<strong>" + $('#item-name-' + ids[0]).data('name') + "</strong>") + "?";
        
        modal_confirm(msg, function(ans) {
            if (ans) {
                showLoading();
                Cube.ajax(this.urls.delete_url, "POST", { ids: this.listID }, function(rs) {
                    hideLoading();
                    if (rs.status) {
                        if(rs.count){
                            modal_alert("Đã crawl được "+rs.count + " bài viết");
                        }else{
                            modal_alert("không có bài viết nào được crawl về");
                        }
                    } else {
                        modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                });
            }
        }.bind(this));
    },
    run: function(ids) {
        this.listID = ids;
        var msg = "bạn có chắc chắn muốn chạy " + (ids.length > 1 ? ids.length + " Task" : "<strong>" + $('#item-name-' + ids[0]).data('name') + "</strong>") + "?";
        modal_confirm(msg, function(ans) {
            if (ans) {
                showLoading();
                Cube.ajax(this.urls.run_url, "POST", { ids: this.listID }, function(rs) {
                    hideLoading();
                    if (rs.status) {
                        if (rs.count) {
                            modal_alert("Đã crawl được "+rs.count+" mới");
                        }else{
                            modal_alert("Chông crawl được bài viết nào!");
                        }
                    } else {
                        modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function (e){
                    hideLoading();
                    modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    console.log(e.getMessage());
                });
            }
        }.bind(this));
    },
    changeStatus: function(id, status) {
        Cube.ajax(this.urls.change_status_url, "POST", { id: id, status: status }, function(rs) {
            if (rs.status) {
                var task = rs.task;
                if (task) {
                    var $btn = $('#task-item-' + task.id + ' .status-text');
                    $btn.html(this.status_list[status]);
                    $btn.removeClass('text-primary')
                        .removeClass('text-secondary')
                        .removeClass('text-danger')
                        .removeClass('text-warning')
                        .addClass('text-' + this.getBtnColor(status));
                    $('#task-item-' + task.id + ' .task-status-select .status-select a').removeClass('active');
                    $('#task-item-' + task.id + '-' + status).addClass('active');
                }
            } else {
                modal_alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }.bind(this));
    }
};

$(function() {
    if (typeof window.tasksInit == 'function') {
        window.tasksInit();
        window.tasksInit = null;
    }

    // delete task
    $(document).on('click', '.btn-delete-task', function() {
        var id = $(this).data('id');
        Cube.tasks.delete([id]);
        return false;
    });

    // delete task
    $(document).on('click', '.btn-run-task', function() {
        var id = $(this).data('id');
        Cube.tasks.run([id]);
        return false;
    });

    // delete all task
    $(document).on('click', '.btn-delete-all-task', function() {
        var list = $('.list-body.list-task input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn task nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.tasks.delete(ids);
        return false;
    });


    // delete all task
    $(document).on('click', '.btn-run-all-task', function() {
        var list = $('.list-body.list-task input[type="checkbox"].check-item:checked');
        var ids = [];
        if (list.length == 0) {
            return modal_alert("Bạn chưa chọn Task nào!");
        }
        for (var i = 0; i < list.length; i++) {
            ids[ids.length] = $(list[i]).val();
        }
        Cube.tasks.run(ids);
        return false;
    });

    $(document).on('click', '.task-status-select .status-select a', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        Cube.tasks.changeStatus(id, status);
    });

    // xem chi tiet task


});