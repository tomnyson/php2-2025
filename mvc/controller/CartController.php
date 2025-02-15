<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";
require_once "model/CartModel.php";
require_once 'model/OrderModel.php';

// enum StatusOrder: string
// {
//     case Pending = 'pending';
//     case Confirm = 'confirm';
//     case Shipping = 'shipping';
//     case Success = 'success';
//     case Cancel = 'cancel';
// }

// enum StatusPayment: string
// {
//     case Pending = 'pending';
//     case Success = 'success';
//     case Cancel = 'cancel';
//     case Error = 'error';
// }
class CartController
{
    private $cartModel;
    private $orderModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        //compact: gom bien dien thanh array
        renderView("view/cart/list.php", compact('carts'), "carts List");
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment = $_POST['payment'];
            if ($payment == 'cod') {
                /**
                 * carts hien  tai
                 * 
                 */
                $user_id = $_SESSION['user']['id'] ?? null;
                $session_id = session_id();
                $carts = $this->cartModel->getCart($user_id, $session_id);
                $total = 0;
                foreach ($carts as $cart) {
                    $total += $cart['price'] * $cart['quantity'];
                }
                $code = uniqid(); // code của order
                $address = $_POST['address'] ?? null;
                $note = $_POST['note'] ?? null;
                $email = $_POST['email'] ?? null;
                $status = 'pendding';
                $isCreate = $this->orderModel->createOrder(
                    $user_id,
                    $code,
                    $total,
                    $address,
                    $note,
                    $status,
                    $payment,
                    $carts
                );
            } else if ($payment == 'vnpay') {
            }
        } else {
            $user_id = $_SESSION['user']['id'] ?? null;
            $session_id = session_id();
            $carts = $this->cartModel->getCart($user_id, $session_id);
            //compact: gom bien dien thanh array
            renderView("view/cart/checkout.php", compact('carts'), "carts List");
        }
    }



    // public function show($id) {
    //     $categories = $this->categoryModel->getCategoryById($id);
    //     renderView("view/category_detail.php", compact('categories'), "categories Detail");
    // }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $user_id = $_SESSION['user']['id'] ?? null;
            $cart_session = session_id();
            $sku = $_POST['sku'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $this->cartModel->addCart($user_id, $cart_session, $sku, $quantity, $price);
            header("Location: /carts");
        } else {
            renderView("view/category_create.php", [], "Create category");
        }
    }

    public function updateQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'];
            $this->cartModel->updateQuantity($id, $quantity);
            $_SESSION['message'] = "Cart updated successfully";
            header("Location: /carts");
        } else {
            header("Location: /carts");
        }
    }
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
    public function delete($id)
    {
        $this->cartModel->deleteCart($id);
        header("Location: /carts");
        exit;
    }
}
