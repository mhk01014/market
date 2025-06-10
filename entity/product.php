<?php
require_once '..\database\dbconnect.php';

class Product {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    public function getProducts() {
        $products = [];
        $sql = "SELECT productid, name, description, price, image FROM product";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        return $products;
    }
}
?>
