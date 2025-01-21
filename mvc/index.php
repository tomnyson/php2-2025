<?php
session_start();
require_once "controller/ProductController.php";
require_once "controller/AuthController.php";
require_once "controller/CategoryController.php";
require_once "controller/ColorController.php";
require_once "controller/SizeController.php";
require_once "controller/ProductVariantController.php";

require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();
$productController = new ProductController();
$authController = new AuthController();
$categoryController = new CategoryController();
$colorController = new ColorController();
$sizeController = new SizeController();
$productVariantController = new ProductVariantController();

$router->addMiddleware('logRequest');

$router->addRoute("/", [$productController, "index"]);
$router->addRoute("/products", [$productController, "index"], ['isUser']); // Accessible to all logged-in users
$router->addRoute("/products/create", [$productController, "create"], ['isAdmin']); // Admin only
$router->addRoute("/products/{id}", [$productController, "show"], ['isUser']); // Accessible to all logged-in users
$router->addRoute("/products/edit/{id}", [$productController, "edit"], ['isAdmin']); // Admin only
$router->addRoute("/products/delete/{id}", [$productController, "delete"], ['isAdmin']); // Admin only
# routers variant products
$router->addRoute("/product-variants/create/{id}", [$productVariantController, "create"]);

// Accessible to all logged-in users
$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/register", [$authController, "register"]);
$router->addRoute("/categories", [$categoryController, "index"], ['isUser']); 
$router->addRoute("/categories/create", [$categoryController, "create"]);
$router->addRoute("/categories/edit/{id}", [$categoryController, "edit"],); 
$router->addRoute("/categories/delete/{id}", [$categoryController, "delete"], ); 

// colors

$router->addRoute("/colors", [$colorController, "index"]); 
$router->addRoute("/colors/create", [$colorController, "create"]);
$router->addRoute("/colors/{id}", [$colorController, "show"]); 
$router->addRoute("/colors/edit/{id}", [$colorController, "edit"],); 
$router->addRoute("/colors/delete/{id}", [$colorController, "delete"], );

// sizes
$router->addRoute("/sizes", [$sizeController, "index"]);
$router->addRoute("/sizes/create", [$sizeController, "create"]);
$router->addRoute("/sizes/{id}", [$sizeController, "show"]);
$router->addRoute("/sizes/edit/{id}", [$sizeController, "edit"]);
$router->addRoute("/sizes/delete/{id}", [$sizeController, "delete"]);

$router->dispatch();
?>