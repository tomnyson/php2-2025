<?php
require_once "Database.php";

class sizeModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM sizes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM sizes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($name) {
        $query = "INSERT INTO sizes (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }
    public function update($id, $name) {
        $query = "UPDATE sizes SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }
    public function delete($id) {
        $query = "DELETE FROM sizes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
}
?>