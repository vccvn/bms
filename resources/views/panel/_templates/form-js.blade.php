<script type="text/javascript" src="{{asset('tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript" src="{{asset('tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('plugins/tinymce.plugin.video.js')}}"></script>
<script src="{{asset('js/profile/form-editor.js')}}"></script>
<script src="{{asset('plugins/moment-with-locales.min.js')}}"></script>
<script src="{{asset('plugins/datetimepicker/bootstrap.js')}}"></script>
<script>
$(document).ready(function() {
    formEditorInit({
        filemanager_path: "{{asset('filemanager')}}/",
        filemanager_plugin: "{{asset('filemanager/plugin.min.js')}}",
    });

});

</script>