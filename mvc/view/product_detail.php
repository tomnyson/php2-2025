
<h1><?= $product['name'] ?></h1>
<div class="row">
    <div class="col-6">
        <!-- <img src="<?= $product['image'] ?>" class="img-fluid" alt="..."> -->
    </div>
    <div class="col-6">
    <?php foreach ($product_variants as $variant) : ?>
        <input type="radio" id="html" name="fav_language" value="<?=$variant['sku'] ?>">
        <label for="html"> <img src="<?= $variant['image'] ?>" class="card-img-top" width="50" height="50" alt="..."></label><br>
    <!-- <div class="card" style="width: 18rem;">
        <img src="<?= $variant['image'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $variant['colorName'] ?> - <?= $variant['sizeName'] ?></h5>
            <p class="card-text">Price: $<?= $variant['price'] ?></p>
            <p class="card-text">Quantity: <?= $variant['quantity'] ?></p>
            <p class="card-text">Sku: <?= $variant['sku'] ?></p> -->
            <?php endforeach; ?>
        </div>
    </div>

    </div>

<p><strong>Description:</strong> <?= $product['description'] ?></p>
<p><strong>Price:</strong> $<?= $product['price'] ?></p>
<a href="/products" class="btn btn-secondary">Back to List</a>