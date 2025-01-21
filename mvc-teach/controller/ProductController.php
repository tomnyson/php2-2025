<?php
require_once "model/ProductModel.php";
require_once "model/ProductVariantModel.php";
require_once "model/ColorModel.php";
require_once "model/SizeModel.php";
require_once "view/helpers.php";

class ProductController {
    private $productModel;
    private $variantModel;
    private $colorModel;
    private $sizeModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->variantModel = new ProductVariantModel();
        $this->colorModel = new ColorModel();
        $this->sizeModel = new SizeModel();
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

    public function addVariant($product_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $color = $_POST['color'];
            $size = $_POST['size'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
    
            $uploadedImages = [];
            if (!empty($_FILES['images']['name'][0])) {
                $uploadDir = 'uploads/';
                foreach ($_FILES['images']['name'] as $key => $imageName) {
                    $tmpName = $_FILES['images']['tmp_name'][$key];
                    $newName = uniqid() . '-' . basename($imageName);
                    $targetPath = $uploadDir . $newName;
    
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedImages[] = $targetPath;
                    }
                }
            }
    
            $imagePaths = json_encode($uploadedImages);
    
            // Save the variant with images
            if ($this->variantModel->createVariant($product_id, $color, $size, $imagePaths, $quantity, $price)) {
                header("Location: /products/$product_id");
                exit;
            } else {
                $error = "Failed to add variant.";
            }
        }
        $colors = $this->colorModel->getAll();
        $sizes = $this->sizeModel->getAll();
        renderView("view/variant/add.php", compact('product_id', 'error','colors', 'sizes'), "Add Variant");
    }

}