<h1>Add Variant</h1>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="color" class="form-label">Color</label>
        <select name="color" id="color" class="form-select" required>
            <option value="" disabled selected>Select a color</option>
            <?php foreach ($colors as $color): ?>
                <option value="<?= htmlspecialchars($color['name']); ?>"><?= htmlspecialchars($color['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <select name="size" id="size" class="form-select" required>
            <option value="" disabled selected>Select a size</option>
            <?php foreach ($sizes as $size): ?>
                <option value="<?= htmlspecialchars($size['name']); ?>"><?= htmlspecialchars($size['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="images" class="form-label">Upload Images</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Variant Price</label>
        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-success">Add Variant</button>
</form>