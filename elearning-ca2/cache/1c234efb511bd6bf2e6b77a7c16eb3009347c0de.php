
<?php $__env->startSection("content"); ?>
<h1 class="text-center my-4">Register</h1>
<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<div class="container">
    <form method="POST" class="w-50 mx-auto border p-4 rounded shadow">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="text-center mt-3">
        Already have an account? <a href="/login">Login</a>
    </p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/php2_2025/elearning-ca2/view/auth/register.blade.php ENDPATH**/ ?>