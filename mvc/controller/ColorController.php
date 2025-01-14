<?php
require_once "model/ColorModel.php";
require_once "view/helpers.php";

class ColorController {
    private $colorModel;

    public function __construct() {
        $this->colorModel = new colorModel();
    }

    public function index() {
        $colors = $this->colorModel->getAll();
        //compact: gom bien dien thanh array
        renderView("view/color/list.php", compact('colors'), "colors List");
    }

    public function show($id) {
        $color = $this->colorModel->getById($id);
        renderView("view/color/detail.php", compact('color'), "color Detail");
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->colorModel->create($name);
            header("Location: /colors");
        } else {
            renderView("view/color/create.php", [], "Create color");
        }
    }
    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->colorModel->update($id, $name);
            header("Location: /colors");
        } else {
            $color = $this->colorModel->getById($id);
            renderView("view/color/edit.php", compact('color'), "Edit color");
        }
    }
    public function delete($id) {
        $this->colorModel->delete($id);
        header("Location: /colors");
        exit;
    }
}