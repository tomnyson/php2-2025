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
    private $productVariantModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->sizeModel = new SizeModel();
        $this->colorModel = new ColorModel();
        $this->productVariantModel = new ProductVariantModel();
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
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $product_id = $_POST['product_id'];
            $colorId = $_POST['colorId'];
            $sizeId = $_POST['sizeId'];
            $image = $_POST['image'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $sku = $_POST['sku'];
            if ($this->productVariantModel->checkExistSku($sku)) {
                $errors[] = "Sku is already exist";
                $products = $this->productModel->getAllProducts();
                $sizes = $this->sizeModel->getAll();
                $colors = $this->colorModel->getAll();
                renderView("view/productsvariant/create.php", compact("products", "colors", "sizes", "errors"), "Create ProductVariants");
            }

            $this->productVariantModel->createVariants($product_id, $colorId, $sizeId, $image, $quantity, $price, $sku);
            $message = "<p class='alert alert-primary '>Create product variant successfully</p>";
            $_SESSION['message'] = $message;
            // header("Location: /products");
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