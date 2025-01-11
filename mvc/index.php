<?php
session_start();
require_once "controller/ProductController.php";
require_once "controller/AuthController.php";
require_once "controller/CategoryController.php";
require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();
$productController = new ProductController();
$authController = new AuthController();
$categoryController = new CategoryController();

$router->addMiddleware('logRequest');

$router->addRoute("/", [$productController, "index"]);
$router->addRoute("/products", [$productController, "index"], ['isUser']); // Accessible to all logged-in users
$router->addRoute("/products/create", [$productController, "create"], ['isAdmin']); // Admin only
$router->addRoute("/products/{id}", [$productController, "show"], ['isUser']); // Accessible to all logged-in users
$router->addRoute("/products/edit/{id}", [$productController, "edit"], ['isAdmin']); // Admin only
$router->addRoute("/products/delete/{id}", [$productController, "delete"], ['isAdmin']); // Admin only
// Accessible to all logged-in users
$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/register", [$authController, "register"]);
$router->addRoute("/categories", [$categoryController, "index"], ['isUser']); 
$router->addRoute("/categories/create", [$categoryController, "create"]);
$router->addRoute("/categories/edit/{id}", [$categoryController, "edit"],); 
$router->addRoute("/categories/delete/{id}", [$categoryController, "delete"], ); 

$router->dispatch();
?>