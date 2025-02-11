<?php
require_once "Database.php";

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCart($user_id, $session_id) {

        $condition = !empty($user_id) ? "user_id = :user_id" : "cart_session = :cart_session";
        
        $query = "SELECT * FROM carts WHERE $condition";
        $stmt = $this->conn->prepare($query);
        if(!empty($user_id)) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $session_id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addCart($user_id, $cart_session, $sku, $quantity, $price) {
        $query = "INSERT INTO carts (user_id, cart_session, sku, quantity, price) VALUES (:user_id, :cart_session, :sku, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':cart_session', $cart_session);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function deleteCart($id) {
        $query = "DELETE FROM carts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateQuantity($id, $quantity) {
        $query = "UPDATE carts SET quantity = :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
}
?>