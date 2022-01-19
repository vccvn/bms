<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$form = new FormData($fd); //tao mang du lieu
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
$title = isset($title)?$title:$slider->name;
$fmact = isset($form_action)?route($form_action):'';

$input_list = ['url','url_post','quantity','repeat_time','dynamic_id','cate_id','user_id','frame_id','status'];
//,crawl_time,run_time

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
            <form id="<?php echo e($form_id); ?>" method="POST" action="<?php echo e($fmact); ?>" enctype="multipart/form-data"  novalidate="true">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="input-hidden-id" value="<?php echo e(old('id', $form->id)); ?>">
                <?php $__currentLoopData = $input_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                    $input = $inputs->get($name);
                    if(!$input) continue;
                    $t = $input->type;
                    ?>
                    <?php if($t=='hidden'): ?>
                        <?php echo $input; ?>

                        <!-- <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?> -->
                    <?php else: ?>
                        <div class="form-group row <?php echo e($input->error?'has-error':''); ?>" id="form-group-<?php echo e($name); ?>">
                            <?php if($name=='repeat_time'): ?>
                                <?php
                                    $run_time = $inputs->get('run_time');
                                    $run_time->label_class = 'item-check';
                                    $run_time->className = 'checkbox';
                                    $crawl_time = $inputs->get('crawl_time');
                                ?>
                                <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                                <div class="input-<?php echo e($t); ?>-wrapper col-sm-3 col-md-2 col-lg-3 col-xl-2">
                                    <?php echo $run_time; ?>

                                </div>
                                <div class="input-<?php echo e($t); ?>-wrapper col-sm-5 col-md-7 col-lg-5 col-xl-7">
                                    <div class="repeat-time-group d-none">
                                        <?php echo $input; ?>

                                        <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                    </div>
                                    <div class="crawl-time-group d-none">
                                        
                                        <div class="input-group datetimepicker-group">
                                            <?php echo $crawl_time; ?>

                                            <div class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </div>
                                        </div>
                                        <?php echo $crawl_time->error?(HTML::span($crawl_time->error,['class'=>'has-error'])):''; ?>

                                    </div>
                                </div>
                            <?php else: ?>
                                <label for="<?php echo e($input->id); ?>" class="form-control-label col-sm-4 col-md-3 col-lg-4 col-xl-3 <?php echo e($input->required?'required':''); ?>" id="label-for-<?php echo e($name); ?>"><?php echo e($input->label); ?></label>
                                <div class="input-<?php echo e($t); ?>-wrapper col-sm-8 col-md-9 col-lg-8 col-xl-9">
                                    <?php echo $input; ?>

                                    <?php echo $input->error?(HTML::span($input->error,['class'=>'has-error'])):''; ?>

                                </div>
                            <?php endif; ?>
                            
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <div class="col-sm-4 col-lg-3"></div>
                    <div class="col-sm-8 col-lg-9">
                        <button class="btn btn-primary" type="submit"><?php echo e($btnSaveText); ?></button> 
                        <button class="btn btn-danger btn-cancel" type="button">Hủy</button>
                    </div>
                    
                </div>
                
            </form>
            
                
        </div>
    </div>


</article>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <style>
    label.required::after{
        content:"*";
        display: inline-block;
        color: #f00;
        margin-left: 5px;
        font-size: 1rem;
        line-height: 1.5;
    }
    .item-check .checkbox-label{
        vertical-align: middle;
    }
    .datetimepicker-group .input-group-addon{
        cursor: pointer;
    }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
<script>
    window.crawlerInit = function() {
        Cube.crawler.init({
            urls:{
                get_categories_url: '<?php echo e(route('admin.crawler.cate')); ?>',
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <?php echo $__env->make($__templates.'datetime', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('js/admin/crawler.js')); ?>"></script>

    <script>
    $(function(){
        function checkRunTime(){
            if($('#run_time').is(':checked')){
                $('.crawl-time-group').removeClass('d-none');
                $('.repeat-time-group').removeClass('d-none').addClass('d-none');
            }else{
                $('.repeat-time-group').removeClass('d-none');
                $('.crawl-time-group').removeClass('d-none').addClass('d-none');
            }
        }
        checkRunTime();
        $('#run_time').click(checkRunTime);

        $('.datetimepicker-group .input-group-addon').click(function () {
            $(this).parent().find('input').click();
        });
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>