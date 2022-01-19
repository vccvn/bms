<?php
use Illuminate\Support\Facades\Input;
$search = Input::get('s');
$cate = Input::get('cate');
$cate = $cate?$cate:"post";
?>


<div class="page-header" style="background-image: url(<?php echo e($siteinfo->page_cover_image(theme_asset('images/slide3.jpg'))); ?>);">
        
    <div class="info-page container">
        <h2 class="title-page">
            Tim kiếm
        </h2>
        <div class="list-inline bread-crumb">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 ml-auto mr-auto">
                        <div class="search-form">
                            <form action="<?php echo e(route('client.search')); ?>" method="get">
                                <?php if($cate): ?>
                                <input type="hidden" name="cate" value="<?php echo e($cate); ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="search" name="s" id="search-input" class="form-control form-control-lg" value="<?php echo e($search); ?>">
                                        
                                        <button type="submit" class="btn btn-warning input-group-btn text-white"><i class="fa fa-search"></i> Tìm kiếm</button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <ul class="bread-crumb">
                            <?php if(isset($cate_list) && $cate_list): ?>
                                <?php $__currentLoopData = $cate_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($current_cate == $cate): ?>
                                        <li class="breadcrumb-item active">
                                            <?php echo e($text); ?>

                                        </li>

                                    <?php else: ?>
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo e(route('client.search',['cate'=>$cate,'s'=>$search])); ?>"><?php echo e($text); ?></a>
                                        </li>    
                                    <?php endif; ?>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    
</div>



