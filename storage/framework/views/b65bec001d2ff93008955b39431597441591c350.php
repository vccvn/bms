<?php $__env->startSection('title', 'Menu; '.$detail->name); ?>

<?php $__env->startSection('content'); ?>


<article class="content items-list-page" id="menu-<?php echo e($detail->id); ?>">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> <?php echo e($detail->name); ?>

                        <a href="<?php echo e($detail->getUpdateUrl()); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete-menu" data-id="<?php echo e($detail->id); ?>"><i class="fa fa-trash"></i></a>
                    </h3>
                    
                </div>
            </div>
        </div>
        <?php echo $__env->make($__templates.'list-search',['search_url'=>$detail->getDetailUrl()], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-5 col-xl-4">
            <h3 class="title mb-2">Thêm item</h3>
            
            <div class="card card-default menu-item-card">
                <?php echo $__env->make($__theme.'menu.templates.form-list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
        <div class="col-sm-7 col-md-8 col-lg-7 col-xl-8">
            <!-- list content -->
            <?php if(count($list = $detail->items())>0): ?>
            <h3 class="title mb-2">Danh sách item</h3>
            <div class="card items menu-items">
                
                <div class="cf nestable-lists">

                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $item->applyMeta(); ?>

                            <li class="dd-item" data-id="<?php echo e($item->id); ?>" id="item-<?php echo e($item->id); ?>">
                                <div class="item-actions">
                                    <a href="<?php echo e($item->getUpdateUrl()); ?>" class="edit btn-edit-item" data-id="<?php echo e($item->id); ?>">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                        <a href="#" class="remove btn-delete-item" data-id="<?php echo e($item->id); ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                                <div class="dd-handle" id="item-name-<?php echo e($item->id); ?>" data-name="<?php echo e($item->title); ?>"><?php echo e($item->title?$item->title:($item->icon?'Icon: '.$item->icon:'')); ?></div>
                                <?php if($item->children): ?>
                                <ol class="dd-list">
                                    <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $child->applyMeta(); ?>
                                        
                                    <li class="dd-item" data-id="<?php echo e($child->id); ?>" id="item-<?php echo e($child->id); ?>">
                                        <div class="item-actions">
                                    
                                            <a href="<?php echo e($child->getUpdateUrl()); ?>" class="edit btn-edit-item" data-id="<?php echo e($child->id); ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="remove btn-delete-item" data-id="<?php echo e($child->id); ?>">
                                                <i class="fa fa-trash-o"></i></a>
                                    
                                        </div>
                                        <div class="dd-handle" id="item-name-<?php echo e($child->id); ?>" data-name="<?php echo e($child->title); ?>"><?php echo e($child->title?$child->title:($child->icon?'Icon: '.$item->icon:'')); ?></div>
                                        
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                    </div>
                </div>

            </div>

            <?php else: ?>
                <div class="text-center alert alert-danger">
                    Chưa có item nào
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php echo $__env->make($__current.'templates.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/nestable2.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsinit'); ?>
<script>
    window.menusInit = function() {
        Cube.menus.init({
            urls:{
                delete_menu_url: '<?php echo e(route('admin.menu.delete')); ?>'
            }
        });
    };
    window.menuItemsInit = function() {
        Cube.menuItems.init({
            urls:{
                sort_url:  '<?php echo e(route('admin.menu.item.sort')); ?>',
                form_url:  '<?php echo e(route('admin.menu.item.form')); ?>',
                save_url:  '<?php echo e(route('admin.menu.item.ajax-save')); ?>',
            },
            menu_id: <?php echo e($detail->id); ?>

        });
    };
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.menu.item.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('js/admin/jquery.nestable.js')); ?>"></script>
<script src="<?php echo e(asset('js/admin/menu.items.js')); ?>"></script>

<?php if($errors->first()): ?>
    <script>
        $(function(){
            modal_alert('<?php echo e($errors->first()); ?>');
        });
    </script>
<?php endif; ?>
        
<?php $__env->stopSection(); ?>

<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>