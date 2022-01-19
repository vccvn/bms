function formEditorInit(data){
    var filemanager_path = data.filemanager_path || '/filemanager/';
    var filemanager_plugin = data.filemanager_plugin || '/filemanager/plugin.min.js';
    
    $(document).ready(function() {

        
        if ($('textarea#content').length) {
            var h = 500;
            if ($('textarea#content').attr('height')) {
                h = $('textarea#content').attr('height');
            }
            tinymce.init({
                selector: 'textarea#content',
                height: h,
                menubar: false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code addvideourl"
                ],
                image_advtab: true ,
                relative_urls : false,
                remove_script_host : false,
                convert_urls : true,
        
        
                external_filemanager_path: filemanager_path,
                filemanager_title:"Thư viện" ,
                external_plugins: { "filemanager" : filemanager_plugin},
                toolbar: 'insert | undo redo | styleselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | link | table | removeformat | code | addvideourl',
                content_css: [
                    '//fonts.googleapis.com/css?family=Source+Sans+Pro',
                    '/css/tinymce.min.css'
                ]
            });
        }
        if ($('textarea.mce-editor').length) {
            var h = 500;
            if ($('textarea.mce-editor').attr('height')) {
                h = $('textarea.mce-editor').attr('height');
            }
            tinymce.init({
                selector: 'textarea.mce-editor',
                height: h,
                menubar: false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager code addvideourl"
                ],
                image_advtab: true ,
                relative_urls : false,
                remove_script_host : false,
                convert_urls : true,
        
        
                external_filemanager_path:filemanager_path,
                filemanager_title:"Thư viện" ,
                external_plugins: { "filemanager" : filemanager_plugin},
                toolbar: 'insert | undo redo | styleselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | link | table | removeformat | code | addvideourl',
                content_css: [
                    '//fonts.googleapis.com/css?family=Source+Sans+Pro',
                    '/css/tinymce.min.css'
                    
                ]
            });
        }
        
        //default date range picker
        
    });
    
}

$(function(){
    if ($('input.inp-date')) {
        $('.inp-date').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD'
        });
    }
    if ($('input.inp-time')) {
        $('.inp-time').datetimepicker({
            locale: 'vi',
            format: 'HH:mm:ss'
        });
    }
    if ($('input.inp-datetime')) {
        $('.inp-datetime').datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    }
});