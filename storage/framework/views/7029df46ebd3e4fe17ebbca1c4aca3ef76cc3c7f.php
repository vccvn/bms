
<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
$cate = Input::get('cate');
$cate = $cate?$cate:"post";
?>

<section class="page-title" style="background-image: url(<?php echo e(get_theme_url('images/background/4.jpg')); ?>);">
    <div class="auto-container">
        <div class="row">
            <div class="col-sm-8">
                <div class="search-form">
                    <form action="<?php echo e(route('client.search')); ?>" method="get">
                        <?php if($cate): ?>
                        <input type="hidden" name="cate" value="<?php echo e($cate); ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" name="s" id="search-input" class="form-control form-control-lg" value="<?php echo e($search); ?>">
                                <span class="input-group-btn input-append">
                                    <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i> Tìm kiếm</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="bread-crumb">
                    <?php if(isset($cate_list) && $cate_list): ?>
                        <?php $__currentLoopData = $cate_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('client.search',['cate'=>$cate,'s'=>$search])); ?>" class="<?php echo e($current_cate == $cate ? "theme_color": ""); ?>"><?php echo e($text); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</section>

