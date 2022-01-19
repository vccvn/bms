/**
 * @author DoanLN
 */
Cube.uploader = {
    forms: [],
    form: function(formSelector, inputname) { // ham constructor
        if (!inputname) inputname = 'image_data[]';
        this.inputname = inputname;
        this.$forms = $(formSelector);
        if (window.File && window.FileList && window.FileReader) {
            this.isBase64 = true;
            for (var n = 0; n < this.$forms.length; n++) {
                var $thisForm = $(this.$forms[n]);
                $thisForm.find('.image-file-select').parent().addClass('image-upload-wrapper');
                $thisForm.find('.image-file-select').before('<a class="btn btn-primary uploader-btn-choose-file" href="#">Chọn file</a>');
                $thisForm.find('.image-file-select').change(function() {
                    var files = $(this).prop("files");
                    var previewItemTemplate = '' +
                        '<div id="upload-item-{$id}" class="upload-preview-item " title="{$filename}">' +
                        '<a class="btn-delete btn-delete-upload-preview-item" href="#" data-id="{$id}">X</a>' +
                        '<img class="upload-preview-item-image" src="{$src}">' +
                        '</div>';
                    for (var i = 0; i < files.length; i++) {
                        (function(file) {

                            if (file.type.indexOf("image") == 0) {
                                var fileReader = new FileReader();
                                fileReader.onload = function(f) {

                                    var id = 'cube-' + Cube.str.rand();
                                    var data = {
                                        src: f.target.result,
                                        width: 200,
                                        height: 200,
                                        title: file.name,
                                        filename: file.name,
                                        id: id
                                    };
                                    var item = Cube.str.eval(previewItemTemplate, data);
                                    $thisForm.find('.uploader-preview').append(item);
                                    $thisForm.find('.uploader-preview-frame').show(500);
                                    $thisForm.prepend('<input type="hidden" name="' + inputname + '" id="' + id + '" value="' + data.src + '">');

                                };

                                fileReader.readAsDataURL(file);
                            }
                        })(files[i]);
                    }
                });
                $thisForm.on('click', '.btn-delete-upload-preview-item', function() {
                    var id = $(this).data('id');
                    $('#upload-item-' + id).hide(400, function() { $(this).remove(); });
                    $('#' + id).remove();
                    return false;
                });
                $thisForm.submit(function() {
                    if (this.isBase64) {
                        $thisForm.find('.image-file-select').remove();
                    }
                    return true;
                }.bind(this));

            }
        } else {
            this.isBase64 = false;
        }
    },
    addForm: function(selector, inputname) {
        var fm = new this.form(selector, inputname);
        this.forms.push(fm);
    }
};

$(function(){
    $(document).on('click', '.btn-delete-uploaded-item', function(){
        var id = $(this).data('id');
        $('#upload-item-' + id).hide(400, function() { $(this).remove(); });
        $('#gallery-hidden-' + id).remove();
        $('#uplpaded-hidden-' + id).remove();
        return false;
    });
});