<?php
require_once "model/CartModel.php";
require_once "view/helpers.php";

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    // Display cart items
    public function index() {
        $cart_session = session_id();
        $user_id = $_SESSION['user']['id'] ?? null;

        $cartItems = $user_id ? 
            $this->cartModel->getCartByUserId($user_id) : 
            $this->cartModel->getCartItems($cart_session);

        renderView("view/cart/cart_list.php", compact('cartItems'), "Cart Items");
    }

    // Add an item to the cart
    public function create() {
        /**
         * kt trương hợp thêm trùm
         * kt số lương thêm vượt qúa hiện tại
         */
        $cart_session = session_id();
        $user_id = $_SESSION['user']['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sku = $_POST['sku'];
            $quantity = (int) $_POST['quantity'];
            $price = (float) $_POST['price'];

            $this->cartModel->addToCart($cart_session, $user_id, $sku, $quantity, $price);
            header("Location: /cart");
        } else {
            renderView("view/cart_create.php", [], "Add to Cart");
        }
    }

    // Edit cart item quantity
    public function edit($id) {
        $cart_session = session_id();
        $user_id = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = (int) $_POST['quantity'];
            $this->cartModel->updateCartItem($cart_session, $user_id, $id, $quantity);
            header("Location: /cart");
        }
        header("Location: /cart");
    }

    // Remove an item from the cart
    public function delete($id) {
        $cart_session = session_id();
        $user_id = $_SESSION['user']['id'] ?? null;

        $this->cartModel->removeCartItem($cart_session, $user_id, $id);
        header("Location: /cart");
        exit;
    }
}