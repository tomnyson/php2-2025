<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'My App'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="h3">PHP2</h1>
            <nav>
                <a href="/" class="text-white me-3">Home</a>
                <a href="/cart" class="text-white ms-3">Cart</a>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        <?php echo $__env->yieldContent('content'); ?> <!-- Ensure this exists inside <main> -->
    </main>

    <footer class="bg-dark text-white py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> My App</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/php2_2025/mvc-teach/view/layouts/master.blade.php ENDPATH**/ ?>