/**
 * @author doanln 
 */

Cube.slugs = {
    input_selector: "",
    urls: {},

    custom_slug: false,
    init: function(args) {

        if (typeof args.urls != 'undefined') {
            var t = Cube.getType(args.urls);
            if (t == 'array' || t == 'object') {
                for (var key in args.urls) {
                    var val = args.urls[key];
                    this.urls[key] = val;
                }
            }
        }

        if (typeof args.input_selector != 'undefined') {
            this.input_selector = args.input_selector;
        }
    },
    checkCustomSlug: function() {
        if ($('#custom_slug').is(":checked")) {
            this.custom_slug = true;
            if ($('input#slug').val().length < 1) {
                this.getSlug();
            }

        } else {
            $('#form-group-slug .slug-message').html("");
            this.custom_slug = false;
            if ($(this.input_selector).val().length) {
                this.getSlug();
            }
        }
        $('input#slug').prop('readonly', !this.custom_slug);
    },

    getSlug: function() {
        if (!this.custom_slug) {
            var title = $(this.input_selector).val();
            var id = $('#input-hidden-id').val();
            Cube.ajax(this.urls.get, "POST", { title: title, id: id }, function(rs) {
                if (rs.status) {
                    if (rs.slug.length) {
                        $("input#slug").val(rs.slug);
                    } else {

                    }
                }
            });
        }
    },

    checkSlug: function() {
        if (!this.custom_slug) return false;
        var slug = $("input#slug").val();
        var id = $('#input-hidden-id').val();
        Cube.ajax(this.urls.check, "POST", { slug: slug, id: id }, function(rs) {
            var msg = "";
            if (rs.status == 1) {
                msg = "Bạn có thể sự dụng slug này";
            } else if (rs.status == 0) {
                msg = "Slug không hợp lệ";
            } else if (rs.status == -1) {
                msg = "Slug không được bõ trống";
            } else {
                msg = "Slug đã được sử dụng trước đó";
            }
            if (rs.status == 1) {
                $('#form-group-slug').removeClass('has-error');
                $('#form-group-slug .slug-message').removeClass("has-error").addClass("text-success").html(msg);
            } else {
                $('#form-group-slug').addClass('has-error');
                $('#form-group-slug .slug-message').removeClass("text-success").removeClass('has-error').addClass('has-error').html(msg);
            }
        });

    }
};

$(function() {
    if (typeof window.slugsInit == 'function') {
        window.slugsInit();
        window.slugsInit = null;
    }
    if (Cube.slugs.input_selector) {

        Cube.slugs.checkCustomSlug();
        $('#custom_slug').click(function() {
            setTimeout(function() {
                Cube.slugs.checkCustomSlug();
            }, 10);
        });
        $(Cube.slugs.input_selector).keyup(function() {
            Cube.slugs.getSlug();
        });
        $(Cube.slugs.input_selector).change(function() {
            Cube.slugs.getSlug();
        });
        if (Cube.slugs.custom_slug) Cube.slugs.checkSlug();
        $('input#slug').keyup(function() {
            Cube.slugs.checkSlug();
        });
        $('input#slug').change(function() {
            Cube.slugs.checkSlug();
        });
    }
});