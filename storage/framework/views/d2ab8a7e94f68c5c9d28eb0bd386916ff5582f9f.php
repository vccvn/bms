<?php
use Cube\Html\Form;
use Cube\Html\HTML;

$title = isset($title)?$title:$siteinfo->title;

$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
///$form = new Cube\Arr($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):'';

$form_properties = [
    'id' => $formid, 
    'method' => 'POST',
    'enctype'=> "multipart/form-data", 
    'action' => $fmact,
    'novalidate' => "true",
    'form_type' => 'laravel',
    'style' => 'bootstrap'
];
$form = new Form($formJSON,$fieldList, $fd, $errors, $form_properties);
// them hanh dong truoc khi render
$form->addAction(function($formgroup,$input, $label){
    $t = $input->type;
    $formgroup->id = 'form-group-'.$input->name;
    $formgroup->inputWrapper->removeClass()->addClass('col-sm-7 col-md-8')->after(
        HTML::div(
            HTML::button('<i class="fa fa-trash"></i>',[
                'type'=>'button',
                'data-id' =>$input->id,
                'class' => 'btn btn-danger btn-sm btn-delete-option-item ml-1'
            ]),[
            'class'=>'col-sm-1 text-center x-dev-only'
        ])
    );

    $formgroup->inputWrapper->addClass('input-'.$t.'-wrapper');
    if(in_array($t,['checkbox','checklist','radio','button','submit','reset','image'])){
        $input->removeClass('form-control');
    }
    if($formgroup->hasError()){
        $formgroup->addClass('has-error');
    }
    if($t=='file'){
        $file_text = HTML::input('text',$input->name.'_show',$input->value,[
            'class' => 'input-file-fake form-control',
            'readonly' => 'true'
        ]);
        $file_text->after(HTML::button('Chọn file',[
                'type' => 'button',
                'class' => 'input-group-addon btn-select-file bg-warning'
            ])
        );
        $div = HTML::div($file_text,['class'=>'input-group']);
        $input->before($div);
        $input->addClass('input-hidden-file');
        $formgroup->addClass('form-input-file-group');
    }
    $formgroup->label->attr('id', 'label-for-'.$input->name);
    $formgroup->label->attr('for', $input->name);
    $formgroup->label->removeClass()->addClass('col-sm-4 col-md-3 form-control-label');
    $formgroup->addClass('option-item option-item-'.$input->id);
    $formgroup->id = 'option-item-'.$input->id;
    
    $input->id = $input->name;
    if(strlen($input->comment)){
        $formgroup->label->append('<br><span class="inp-comment">('.$input->comment.')</span>');
    }
})
->prepend(HTML::input("hidden",'option_group',$option_group))
->prepend('<!-- test -->')
->buttonSubmit($btnSaveText);

?>



<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> 
                        <?php echo e($title); ?>

                        <a href="#" class="btn btn-primary btn-sm rounded-s btn-add-option-item"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        <?php echo $__env->make($__templates.'list-search',['search_url'=>route('admin.option.group',['option_group'=>$option_group])], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card card-block sameheight-item">
            <div class="title-block">
                <h3 class="title"> <?php echo e(isset($form_title)?$form_title:$title); ?> </h3>
            </div>
            <?php echo $form; ?>

                
        </div>
    </div>


</article>

<?php $__env->stopSection(); ?>


<?php $templates = json_encode('<div class="form-group row form-input-{$type}-group option-item option-item-{$id}" id="option-item-{$id}">
    <label for="{$id}" class="col-sm-4 col-md-3 form-control-label" id="label-for-{$id}">{$name}<span class="inp-comment">{$cmt}</span></label>
    <div class="col-sm-7 col-md-8 input-{$type}-wrapper">
        {$input}
    </div>
    <div class="col-sm-1 text-center ">
        <button type="button" data-id="{$id}" class="btn btn-danger btn-sm btn-delete-option-item ml-1">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>
');
?>
<?php $__env->startSection('jsinit'); ?>
<script>
    var group_template = <?php echo $templates; ?>;
    var input_templates = <?php echo json_encode([
        'text' => '<input type="text" name="{$name}" id="{$name}" class=" form-control" placeholder="nhập {$name}" />',
        'email' => '<input type="email" name="{$name}" id="{$name}" class=" form-control" placeholder="nhập {$name}" />',
        'number' => '<input type="number" name="{$name}" id="{$name}" class=" form-control" placeholder="nhập {$name}" />',
        'textarea' => '<textarea name="{$name}" id="{$name}" class=" form-control" placeholder="nhập {$name}"></textarea>',
        'file' => '<div class="input-group"><input class="input-file-fake form-control" readonly="true" type="text" name="{$name}_show" /><button type="button" class="input-group-addon btn-select-file">Chọn file</button></div><input type="file" name="{$name}" id="{$name}" class=" form-control input-hidden-file" />'
    ]); ?>;



    window.optionsInit = function() {
        Cube.options.init({
            urls:{
                delete_url: '<?php echo e(route('admin.option.delete')); ?>',
                add_item_url: '<?php echo e(route('admin.option.add')); ?>'
            },
            template:{
                form_group: group_template,
                inputs:input_templates
            },
            option_group: "<?php echo e($option_group); ?>"
        });
    };
</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/datetimepicker/bootstrap.css')); ?>" />
    <style>
    .inp-comment{
        font-size: 12px;
        color: silver;
    }
    textarea{
        max-height: 500px;
    }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('js/admin/options.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('admin.option.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>