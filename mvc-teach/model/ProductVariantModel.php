<?php
require_once "Database.php";

class ProductVariantModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createVariant($product_id, $color, $size, $image, $quantity, $price) {
        $query = "INSERT INTO product_variants (product_id, color, size, image, quantity, price) 
                  VALUES (:product_id, :color, :size, :image, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function getVariantsByProductId($product_id) {
        $query = "SELECT * FROM product_variants WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>