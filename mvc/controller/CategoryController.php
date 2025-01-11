<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new categoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategory();
        //compact: gom bien dien thanh array
        renderView("view/category_list.php", compact('categories'), "categories List");
    }

    public function show($id) {
        $categories = $this->categoryModel->getCategoryById($id);
        renderView("view/category_detail.php", compact('categories'), "categories Detail");
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->categoryModel->createCategory($name);
            header("Location: /categories");
        } else {
            renderView("view/category_create.php", [], "Create category");
        }
    }
    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->categoryModel->updateCategory($id, $name);
            header("Location: /categories");
        } else {
            $categories = $this->categoryModel->getCategoryById($id);
            renderView("view/category_edit.php", compact('categories'), "Edit categories");
        }
    }
    public function delete($id) {
        $this->categoryModel->deleteCategory($id);
        header("Location: /categories");
        exit;
    }
}