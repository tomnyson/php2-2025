<h1>Create Size</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name">
        <span class="text-danger"><?= $error['name'] ?? "" ?></span>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
 
</form>
