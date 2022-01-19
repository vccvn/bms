<script type="text/javascript" src="<?php echo e(asset('tinymce/tinymce.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('tinymce/jquery.tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/tinymce.plugin.video.js')); ?>"></script>
<script src="<?php echo e(asset('js/admin/form-editor.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/moment-with-locales.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datetimepicker/bootstrap.js')); ?>"></script>
<script>
$(document).ready(function() {
    formEditorInit({
        filemanager_path: "<?php echo e(asset('filemanager')); ?>/",
        filemanager_plugin: "<?php echo e(asset('filemanager/plugin.min.js')); ?>",
    });

});

</script>