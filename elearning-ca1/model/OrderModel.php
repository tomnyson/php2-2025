
<?php
require_once "Database.php";

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getOrders() {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderByUserId($user_id){
        $query = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // create createOrderDetail
    public function createOrderDetail($order_id, $sku, $quantity, $price) {
        $query = "INSERT INTO order_items (orderId, sku, quantity, price) VALUES (:order_id, :sku, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // create order
    public function createOrder($user_id, $code, $total, $address, $note, $status, $paymentMethod, $carts ) {
        $query = "INSERT INTO orders (userId, code, total, address, note, status, paymentMethod, createDate) VALUES (:user_id, :code, :total, :address, :note, :status, :payment_method, :createDate)";
        $stmt = $this->conn->prepare($query);
        $date = date('Y-m-d H:i:s');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':createDate', $date, PDO::PARAM_STR);
        $stmt->execute();
        // sau thi add success lastInsertId -> foreach carts -> add order_detail -> insert all order_detail
            $order_id = $this->conn->lastInsertId();
            foreach($carts as $cart) {
                $this->createOrderDetail($order_id, $cart['sku'], $cart['quantity'], $cart['price']);
            }
            return true;

    }
}
/**
 * get orders
 * get order by userId
 * add order
 * update order
 * delete order
 */
