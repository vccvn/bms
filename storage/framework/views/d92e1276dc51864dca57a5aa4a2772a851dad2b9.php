<?php $__env->startSection('title','Giỏ hàng'); ?>

<?php $__env->startSection('content'); ?>

        <!--Cart Section-->
        <section class="cart-section">
            <div class="auto-container">
                <?php if($cart_data['qty']): ?>
                <!--Cart Outer-->
                <div class="cart-outer">
                    <div class="table-outer">
                        <table class="cart-table">
                            <thead class="cart-header">
                                <tr>
                                    <th><span class="fa fa-trash-o"></span></th>
                                    <th class="prod-column">Sản phẩm</th>
                                    <th class="price">Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $__currentLoopData = $cart_data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="product-cart-item-<?php echo e($p['key']); ?>">
                                    <td class="remove"><a href="#" class="remove-btn btn-remove-cart-item" data-key="<?php echo e($p['key']); ?>"><span class="fa fa-remove"></span></a></td>
                                    <td class="prod-column">
                                        <div class="column-box">
                                            <figure class="prod-thumb"><a href="#"><img src="<?php echo e($p['image']); ?>" alt=""></a></figure>
                                            <h4 class="prod-title"><?php echo e($p['name']); ?></h4>
                                        </div>
                                    </td>
                                    <td class="price"><?php echo e(number_format($p['price'], 0, ',', '.')); ?></td>
                                    <td class="qty"><input class="quantity-spinner item-quantity" type="text" value="<?php echo e($p['qty']); ?>" name="quantity" data-key="<?php echo e($p['key']); ?>"></td>
                                    <td class="sub-total" id="item-total-price-<?php echo e($p['key']); ?>"><?php echo e(number_format($p['total_price'], 0, ',', '.')); ?></td>
                                    
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="cart-options clearfix">
                        
                        
                        <div class="pull-right">
                            <button type="button" class="theme-btn btn-style-one btn-go-to-checkout">Thanh toán</button>
                            <button type="button" class="theme-btn btn-style-three btn-update-cart">Cập nhật</button>
                        </div>
                        
                    </div>
                    
                    <div class="row clearfix">
                        
                        <div class="column pull-right col-md-4 col-sm-8 col-xs-12">
                            <h3>Cart Totals</h3>
                            <!--Totals Table-->
                            <ul class="totals-table">
                                <li class="clearfix title"><span class="col">Sub Total</span><span class="col cart-total-money"><?php echo e(number_format($cart_data['total_money'], 0, ',', '.')); ?> VNĐ</span></li>
                                <li class="clearfix"><span class="col">Order</span><span class="col total cart-total-money-vat"><?php echo e(number_format($__setting->order_VAT?($cart_data['total_money']*(1+($__setting->order_VAT/100))):$cart_data['total_money'], 0, ',', '.')); ?> VNĐ</span></li>
                            </ul>
                            
                        </div>
                        
                    </div>
                    
                    
                </div>
                <?php else: ?>
                <div class="alert alert-warning text-center">
                    Hiện không có sản phẩm nào trong giỏ hàng
                </div>
                <?php endif; ?>
            </div>
        </section>
    

<?php $__env->stopSection(); ?>

<?php if(!$cart_data['qty']): ?>
    <?php $__env->startSection('js'); ?>
        <script>
            $(document).ready(function(){
                Cube.storage.set('cart_total',0);
                Cube.cart.updateCartTotal(0);
            });
        </script>
    <?php $__env->stopSection(); ?>
<?php endif; ?>


<?php echo $__env->make($__layouts.'fullwidth-page-title', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>