
<div class="container mt-5">
    <h2 class="mb-4">Your Shopping Cart</h2>

    <?php if (!empty($cartItems)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['sku']) ?></td>
                            <td>
                                <form action="/cart/edit/<?= $item['id'] ?>" method="post" class="d-flex align-items-center">
                                    <input type="number" class="form-control w-50" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                    <button type="submit" class="btn btn-primary btn-sm ms-2">Update</button>
                                </form>
                            </td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                            <td>
                                <a href="/cart/delete/<?= $item['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a href="/cart/clear" class="btn btn-warning">Clear Cart</a>
            <a href="/products" class="btn btn-secondary">Continue Shopping</a>
        </div>
    <?php else : ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="/products" class="btn btn-primary">Continue Shopping</a>
    <?php endif; ?>
</div>
