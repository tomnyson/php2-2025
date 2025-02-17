

<?php $__env->startSection('content'); ?>
<h2>Cart List</h2>
<?php if(count($carts) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($cart['sku']); ?></td>
                        <td><?php echo e($cart['quantity']); ?></td>
                        <td>$<?php echo e(number_format($cart['price'], 2)); ?></td>
                        <td>$<?php echo e(number_format($cart['price'] * $cart['quantity'], 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/php2_2025/mvc-teach/view/cart/cart_list.blade.php ENDPATH**/ ?>