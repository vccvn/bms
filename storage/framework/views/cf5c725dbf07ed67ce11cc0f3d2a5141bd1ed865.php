<?php $__env->startSection('title', 'Bảng giá vé'); ?>

<?php $__env->startSection('content'); ?>

<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Bảng giá vé
                        <a href="<?php echo e(route('admin.ticket.price.add')); ?>" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->

    <div class="card items">
        <?php echo $__env->make('admin._templates.search-filter',[
            'search_filter'=>[
                'route' => 'Tên tuyến',
                'company' => 'Nhà xe',
                'price' => 'Giá vé'
            ]
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if($list->count()>0): ?>
        <div class="cart cart-block pl-3 pr-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <label class="d-block">
                                    <input type="checkbox" name="check_all" class="check-all checkbox">
                                    <span></span>
                                </label>
                            </th>    
                            <th>
                                Mã số
                            </th>    
                            <th>
                                Nhà xe
                            </th>    
                            <th>
                                Tuyến
                            </th>    
                            <th>
                                Giá vé (VNĐ)
                            </th>
                            <th>
                                #
                            </th>    
                            
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="item-<?php echo e($item->id); ?>">
                                <th>
                                    <label class="d-block">
                                        <input type="checkbox" name="roles[<?php echo e($loop->index); ?>][id]" class="check-item checkbox" value="<?php echo e($item->id); ?>">
                                        <span></span>
                                    </label>
                                </th>
                                <td>
                                    <?php echo e($item->id); ?>

                                </td>
                                <td>
                                    <?php echo e($item->company); ?>

                                </td>
                                <td>
                                    <?php echo e($item->from_station); ?> 
                                    <i class="fa fa-long-arrow-right"></i>
                                    <?php echo e($item->to_station); ?>

                                </td>
                                <td>
                                    <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                </td>
                                <td>
                                    <a href="<?php echo e($item->getUpdateUrl()); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm btn-delete-item" data-id="<?php echo e($item->id); ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
    
                </table>
            </div>
        </div>
        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-4">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-8">
                    <nav aria-label="Page navigation example" class="text-right">
                        <?php echo e($list->links('vendor.pagination.custom')); ?>

                    </nav>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
        <?php endif; ?>
        
    </div>

</article>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('jsinit'); ?>
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '<?php echo e(route('admin.ticket.price.delete')); ?>'
            }
        });
    };
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($__layouts.'main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>