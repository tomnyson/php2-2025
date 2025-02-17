<?php
require_once "model/SizeModel.php";
require_once "view/helpers.php";

class SizeController {
    private $sizeModel;

    public function __construct() {
        $this->sizeModel = new sizeModel();
    }

    public function index() {
        $sizes = $this->sizeModel->getAll();
        //compact: gom bien dien thanh array
        renderView("view/size/list.php", compact('sizes'), "size List");
    }

    public function show($id) {
        $size = $this->sizeModel->getById($id);
        renderView("view/size/detail.php", compact('size'), "size Detail");
    }
    public function create() {
      
        $error = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            if (empty($name)) {
                $error['name'] = "Name is required";
                renderView("view/size/create.php", compact('error'), "Create size");
            }else {
                $this->sizeModel->create($name);
            header("Location: /sizes");
            }

        } else {
            renderView("view/size/create.php", compact('error'), "Create size");
            
        }
    }
    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->sizeModel->update($id, $name);
            header("Location: /size");
        } else {
            $size = $this->sizeModel->getById($id);
            renderView("view/size/edit.php", compact('size'), "Edit size");
        }
    }
    public function delete($id) {
        $this->sizeModel->delete($id);
        header("Location: /sizes");
        exit;
    }
}