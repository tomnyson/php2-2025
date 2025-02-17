<h1>Categories List</h1>
<a href="/categories/create" class="btn btn-primary mb-3">Create Categories</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $categories): ?>
        <tr>
            <td><?= $categories['id'] ?></td>
            <td><?= $categories['name'] ?></td>
            <td>
                <a href="/categories/<?= $categories['id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/categories/edit/<?= $categories['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/categories/delete/<?= $categories['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>