<?php
require_once "model/ProductModel.php";
require_once "model/ProductVariantsModel.php";
require_once "model/ColorModel.php";
require_once "model/SizeModel.php";
require_once "view/helpers.php";

class ProductVariantController {
    private $productModel;
    private $sizeModel;
    private $colorModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->sizeModel = new SizeModel();
        $this->colorModel = new ColorModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        //compact: gom bien dien thanh array
        renderView("view/product_list.php", compact('products'), "Product List");
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        renderView("view/product_detail.php", compact('product'), "Product Detail");
    }

    public function create($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            $this->productModel->createProduct($name, $description, $price);
            header("Location: /products");
        } else {
            $products = $this->productModel->getAllProducts();
            $sizes = $this->sizeModel->getAll();
            $colors = $this->colorModel->getAll();

            renderView("view/productsvariant/create.php", compact("products", "colors", "sizes"), "Create ProductVariants");
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