        <h2 class="mb-4">Checkout</h2>

        <!-- Display Cart Items -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Sku</th>
                    <th>image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;

                ?>

                <?php foreach ($carts as $cart): ?>

                    <tr>
                        <td><?= $cart['id'] ?></td>
                        <td><?= $cart['sku'] ?></td>
                        <td>
                            <img src="<?= $cart['image'] ?>" alt="image 404" style="width: 100px">
                        <td>
                            <form action="/carts/update/<?= $cart['id'] ?>" method="post" class="d-flex">
                                <input type="number" readonly value="<?= $cart['quantity'] ?>" class="form-control" min="0" style="width: 100px" name="quantity" />
                            </form>
                        </td>
                        <td><?= $cart['price'] ?></td>
                        <td><?= $cart['price'] * $cart['quantity'] ?> 
                        <?php
                            $total += $cart['price'] * $cart['quantity'];
                        ?>

                        </td>
                    </tr>
                    <?php
                    ?> <?php endforeach; ?>


            </tbody>
        </table>

        <h4>
            <td colspan="4">Total</td>
            <?= $total ?>
        </h4>
        <!-- Checkout Form -->
        <form action="/checkout" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <textarea name="email" id="address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Note</label>
                <textarea name="note" id="address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="payment" class="form-label">Payment Method</label>
                <select name="payment" id="payment" class="form-control" required>
                    <option value="cod">COD</option>
                    <option value="vnpay">VNPAY</option>
                    <option value="momo">MOMO</option>
                    <option value="zalopay">ZALO PAY</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
            <a href="/carts" class="btn btn-secondary">Back to Cart</a>
        </form>