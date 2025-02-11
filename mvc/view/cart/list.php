<h1>Cart List</h1>
<a href="/cart/create" class="btn btn-primary mb-3">Create cart</a>

<?php 
if(count($carts) == 0){
    echo "<h5 class='text-center'>No carts found</h5>";
}

?>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>sku</th>
            <th>quantity</th>
            <th>Price</th>
            <th>total</th>
            <th>Actions</th>
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
                <form action="/carts/update/<?= $cart['id'] ?>" method="post" class="d-flex">
                    <input type="number" value="<?= $cart['quantity'] ?>" class="form-control" min="0" style="width: 100px" name="quantity"/>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>
                </td>
                <td><?= $cart['price'] ?></td>
                <td><?= $cart['price'] * $cart['quantity'] ?> <?php
                                                                $total += $cart['price'] * $cart['quantity'];
                                                                ?>
                </td>

                <td>
                    <a href="/carts/<?= $cart['id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="/carts/edit/<?= $cart['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/carts/delete/<?= $cart['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr>
            <td colspan="4">Total</td>
            <td><?= $total ?></td>
        </tr>
    </tbody>
</table>