<?php
use Cube\Html\Form;
use Cube\Html\HTML;

$title = isset($title)?$title:"cubeAdmin";
$fd = isset($formdata)?$formdata:null; // form data
$formid = isset($form_id)?$form_id:null;
$form = new Cube\Arr($fd); //tao mang du lieu
$fmact = isset($form_action)?route($form_action):'';
$form_properties = [
    'id' => $formid, 
    'method' => 'POST',
    'enctype'=> "multipart/form-data", 
    'action' => $fmact,
    'novalidate' => 'true',
    'form_type' => 'laravel',
    'style' => 'bootstrap'
];

$form = new Form($formJSON,$fieldList, $fd, $errors, $form_properties);

$form->addAction(function($formgroup,$input){
    $t = $input->type;
    $formgroup->id = 'form-group-'.$input->name;
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
    $formgroup->label->attr('id', 'label-for-'.$input->id);
})
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
                    <h3 class="title"> <?php echo e($title); ?>

                        <?php if(isset($back_link)): ?> 
                            <a href="<?php echo e($back_link); ?>" class="btm btn-primary btn-sm"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <?php endif; ?>
                    </h3>
                    
                </div>
            </div>
        </div>
        
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

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/datetimepicker/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-select/css/bootstrap-select.css')); ?>" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap-select/js/bootstrap-select.js')); ?>"></script>
    <?php echo $__env->make($__templates.'form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>