<?php
require_once "Database.php";

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all items in the cart by session
    public function getCartItems($cart_session) {
        $query = "SELECT * FROM carts WHERE cart_session = :cart_session";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_session', $cart_session);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all items in the cart by user ID
    public function getCartByUserId($user_id) {
        $query = "SELECT * FROM carts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add an item to the cart
    public function addToCart($cart_session, $user_id, $sku, $quantity, $price) {
        // Decide whether to use cart_session or user_id
        $condition = $user_id ? "user_id = :user_id" : "cart_session = :cart_session";
        
        // Check if the item already exists
        $query = "SELECT * FROM carts WHERE $condition AND sku = :sku";
        $stmt = $this->conn->prepare($query);
        
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $cart_session);
        }
        
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existingItem) {
            // Update quantity if item already exists
            $query = "UPDATE carts SET quantity = quantity + :quantity WHERE $condition AND sku = :sku";
            $stmt = $this->conn->prepare($query);
            
            if ($user_id) {
                $stmt->bindParam(':user_id', $user_id);
            } else {
                $stmt->bindParam(':cart_session', $cart_session);
            }
    
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':quantity', $quantity);
            return $stmt->execute();
        } else {
            // Insert new item into cart
            $query = "INSERT INTO carts (cart_session, user_id, sku, quantity, price) 
                      VALUES (:cart_session, :user_id, :sku, :quantity, :price)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cart_session', $cart_session);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':price', $price);
            return $stmt->execute();
        }
    }

    // Update item quantity in the cart
    public function updateCartItem($cart_session, $user_id, $id, $quantity) {
        try {
            // Ensure quantity is a positive integer
            if (!is_numeric($quantity) || $quantity <= 0) {
                return false; // Invalid quantity
            }
    
            // Determine whether to use user_id or cart_session
            $condition = (!empty($user_id)) ? "user_id = :user_id" : "cart_session = :cart_session";
    
            // Check if item exists before updating
            $checkQuery = "SELECT id FROM carts WHERE $condition AND id = :id";
            $checkStmt = $this->conn->prepare($checkQuery);
    
            if (!empty($user_id)) {
                $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            } else {
                $checkStmt->bindParam(':cart_session', $cart_session, PDO::PARAM_STR);
            }
    
            $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            $existingItem = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$existingItem) {
                return false; // Item does not exist in the cart
            }
    
            // Update the item quantity
            $query = "UPDATE carts SET quantity = :quantity WHERE $condition AND id = :id";
            $stmt = $this->conn->prepare($query);
    
            if (!empty($user_id)) {
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':cart_session', $cart_session, PDO::PARAM_STR);
            }
    
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Fixed incorrect binding
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    
            // Debugging SQL query (optional)
            // $stmt->debugDumpParams();
            // die();
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating cart item: " . $e->getMessage());
            return false;
        }
    }

    // Remove an item from the cart
    public function removeCartItem($cart_session, $user_id, $id) {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return false; // Invalid item ID
            }
    
            // Determine whether to use user_id or cart_session
            $condition = (!empty($user_id)) ? "user_id = :user_id" : "cart_session = :cart_session";
    
            $query = "DELETE FROM carts WHERE $condition AND id = :id";
            $stmt = $this->conn->prepare($query);
    
            if (!empty($user_id)) {
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':cart_session', $cart_session, PDO::PARAM_STR);
            }
    
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error removing cart item: " . $e->getMessage());
            return false;
        }
    }

    // Clear all items from the cart
    public function clearCart($cart_session, $user_id = null) {
        // Use user_id if available; otherwise, use cart_session
        $condition = $user_id ? "user_id = :user_id" : "cart_session = :cart_session";
        $query = "DELETE FROM carts WHERE $condition";
        
        $stmt = $this->conn->prepare($query);
        
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $cart_session);
        }
    
        return $stmt->execute();
    }
}
?>