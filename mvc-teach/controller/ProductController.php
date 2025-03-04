<?php
require_once "model/ProductModel.php";
require_once "model/ProductVariantsModel.php";
require_once "view/helpers.php";

class ProductController {
    private $productModel;
    private $productVariantsModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->productVariantsModel = new ProductVariantModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        
        //compact: gom bien dien thanh array
        renderView("view/product_list.php", compact('products'), "Product List");
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id); 
        $product_variants = $this->productVariantsModel->getVariantByProductId($id);
        echo "<pre>";
        // var_dump($product_variants);
        echo "</pre>";
        renderView("view/product_detail.php", compact('product_variants', 'product'), "Product Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $this->productModel->createProduct($name, $description, $price);
            header("Location: /products");
        } else {
            renderView("view/product_create.php", [], "Create Product");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $this->productModel->updateProduct($id, $name, $description, $price);
            header("Location: /products");
        } else {
            $product = $this->productModel->getProductById($id);
            renderView("view/product_edit.php", compact('product'), "Edit Product");
        }
    }

    public function delete($id) {
        $this->productModel->deleteProduct($id);
        header("Location: /products");
        exit;
    }
}