<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";
require_once "model/CartModel.php";
class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function index() {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        //compact: gom bien dien thanh array
        renderView("view/cart/list.php", compact('carts'), "carts List");
    }

    // public function show($id) {
    //     $categories = $this->categoryModel->getCategoryById($id);
    //     renderView("view/category_detail.php", compact('categories'), "categories Detail");
    // }
    // public function create() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $this->categoryModel->createCategory($name);
    //         header("Location: /categories");
    //     } else {
    //         renderView("view/category_create.php", [], "Create category");
    //     }
    // }
    // public function edit($id){
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $this->categoryModel->updateCategory($id, $name);
    //         header("Location: /categories");
    //     } else {
    //         $categories = $this->categoryModel->getCategoryById($id);
    //         renderView("view/category_edit.php", compact('categories'), "Edit categories");
    //     }
    // }
    public function delete($id) {
        $this->cartModel->deleteCart($id);
        header("Location: /carts");
        exit;
    }
}