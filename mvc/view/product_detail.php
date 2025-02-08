<?php
// Ensure product and variants exist before displaying
if (!isset($product) || empty($product)) {
    echo "<p>Product not found.</p>";
    exit;
}

// tạo 3 mảng
$colors = [];
$sizes = [];
$variantMap = [];

if (!empty($product_variants)) {
    foreach ($product_variants as $variant) {
        if (!empty($variant['colorName']) && !in_array($variant['colorName'], $colors)) {
            // thêm màu vào mảng colors
            $colors[] = $variant['colorName'];
        }
        if (!empty($variant['sizeName']) && !in_array($variant['sizeName'], $sizes)) {
            // thêm size vào mảng sizes
            $sizes[] = $variant['sizeName'];
        }
        // Map variants for quick lookup
        $variantMap[$variant['colorName']][$variant['sizeName']] = $variant;
        // echo "<pre>";
        // var_dump($variantMap);
        // echo "</pre>";

    }
}
?>

<h1><?= htmlspecialchars($product['name']) ?></h1>

<div class="row">
    <div class="col-6">
        <!-- Display main product image -->
        <img id="productImage" src="<?= !empty($product['image']) ? htmlspecialchars($product['image']) : 'placeholder.jpg' ?>" 
            class="img-fluid" 
            alt="<?= !empty($product['name']) ? htmlspecialchars($product['name']) : 'No Name' ?>">
    </div>

    <div class="col-6">
        <h4>Choose Variant:</h4>
        <form action="/carts/create" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

            <!-- Color Selection -->
            <label for="colorSelect"><strong>Select Color:</strong></label>
            <select id="colorSelect" name="color" class="form-control" required>
                <option value="">-- Choose Color --</option>
                <?php foreach ($colors as $color) : ?>
                    <option value="<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($color) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Size Selection -->
            <label for="sizeSelect" class="mt-3"><strong>Select Size:</strong></label>
            <select id="sizeSelect" name="size" class="form-control" required disabled>
                <option value="">-- Choose Size --</option>
                <?php foreach ($sizes as $size) : ?>
                    <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Hidden SKU Field -->
            <input type="hidden" id="selectedSku" name="sku" value="">
            <input type="hidden" id="selectedPrice" name="price" value="">
            <!-- Quantity Input -->
            <label for="quantityInput" class="mt-3"><strong>Quantity:</strong></label>
            <input type="number" id="quantityInput" name="quantity" class="form-control" min="1" value="1" required disabled>

            <!-- Add to Cart Button -->
            <button type="submit" id="addToCartBtn" class="btn btn-primary mt-3" disabled>Add to Cart</button>
        </form>
    </div>
</div>

<!-- Product Details -->
<p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
<p><strong>Price:</strong> $<span id="productPrice"><?= number_format($product['price'], 2) ?></span></p>
<p><strong>SKU:</strong> <span id="productSku">N/A</span></p>
<p><strong>Available Quantity:</strong> <span id="productQuantity">N/A</span></p>

<a href="/cart.php" class="btn btn-secondary mt-3">Go to Cart</a>

<!-- show sản phẩm đúng với attribute -->
<script>
  const variantMap = <?= json_encode($variantMap, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>;
    
    const colorSelect = document.getElementById('colorSelect');
    const sizeSelect = document.getElementById('sizeSelect');
    const quantityInput = document.getElementById('quantityInput');
    const productImage = document.getElementById('productImage');
    const productPrice = document.getElementById('productPrice');
    const productSku = document.getElementById('productSku');
    const productQuantity = document.getElementById('productQuantity');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const selectedSku = document.getElementById('selectedSku');
    const selectedPrice = document.getElementById('selectedPrice');

    colorSelect.addEventListener('change', function() {
        sizeSelect.innerHTML = '<option value="">-- Choose Size --</option>';
        sizeSelect.disabled = true;
        quantityInput.disabled = true;
        addToCartBtn.disabled = true;
        selectedSku.value = "";
        productSku.textContent = "N/A";
        productQuantity.textContent = "N/A";

        const selectedColor = this.value;
        console.log("variant Map", variantMap);
        if (variantMap[selectedColor]) {
            sizeSelect.disabled = false;
            Object.keys(variantMap[selectedColor]).forEach(size => {
                sizeSelect.innerHTML += `<option value="${size}">${size}</option>`;
            });
        }
    });

    sizeSelect.addEventListener('change', function() {
        addToCartBtn.disabled = true;
        selectedSku.value = "";
        productSku.textContent = "N/A";
        productQuantity.textContent = "N/A";
        quantityInput.disabled = true;

        const selectedColor = colorSelect.value;
        const selectedSize = this.value;
        
        if (variantMap[selectedColor] && variantMap[selectedColor][selectedSize]) {
            const variant = variantMap[selectedColor][selectedSize];
            productImage.src = variant.image ? variant.image : 'placeholder.jpg';
            productPrice.textContent = `${parseFloat(variant.price).toFixed(2)}`;
            productSku.textContent = variant.sku;
            selectedSku.value = variant.sku;
            productQuantity.textContent = variant.quantity;
            quantityInput.disabled = false;
            addToCartBtn.disabled = false;
            selectedPrice.value = variant.price;
        }
    });


    quantityInput.addEventListener('change', function() {
        const quantity = parseInt(this.value);
        const availableQuantity = parseInt(productQuantity.textContent);
        if (quantity > availableQuantity) {
            this.value = availableQuantity;
            alert(`Only ${availableQuantity} available in stock.`);
        }
    });

</script>