<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "My App" ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3">PHP2</h1>
                <nav>
                    <a href="/" class="text-white me-3">Home</a>
                    <a href="/products" class="text-white">Products</a>
                    <a href="/categories" class="text-white ms-3">Categories</a>
                    <a href="/colors" class="text-white ms-3">Colors</a>
                    <a href="/sizes" class="text-white ms-3">Sizes</a>
                    <a href="/product-variants/create/1" class="text-white ms-3">Add variant</a>
                    <a href="/carts" class="text-white ms-3">Cart</a>
                </nav>
            </div>
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="me-3">Welcome, <?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <a href="/logout" class="btn btn-light btn-sm">Logout</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-light btn-sm">Login</a>
                    <a href="/register" class="btn btn-light btn-sm">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="container my-4">
        <?php
        if (!isset($_SESSION['message'])) {
            $_SESSION['message'] = "";
        } else {
            echo $_SESSION['message'];
            // var_dump($_SESSION['message']);
            unset($_SESSION['message']);
        }
        ?>
        <?= $content ?>
    </main>
    <footer class="bg-dark text-white py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y") ?> My App</p>
        </div>
    </footer>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>