<?php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "market";
    public $conn;

    function __construct() 
    {
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }

        // Fetch API data
        $response = file_get_contents('https://fakestoreapi.com/products');
        if (!$response) {
            echo "Failed to fetch API data.";
            return;
        }

        $products = json_decode($response, true);

        // Fetch seller IDs
        $sellerid = [];
        $res = $this->conn->query("SELECT userid FROM users WHERE role = 'seller'");
        if (!$res) {
            die("Query failed: " . $this->conn->error);
        }
        while ($row = $res->fetch_assoc()) {
            $sellerid[] = $row['userid'];
        }

        // Abort if no sellers
        if (empty($sellerid)) {
            echo "No sellers found in database.";
            return;
        }

        // Insert products
        foreach ($products as $product) {
            $productid = $product['id'];
            $name = $this->conn->real_escape_string($product['title']);
            $description = $this->conn->real_escape_string($product['description']);
            $image = $this->conn->real_escape_string($product['image']);
            $category = $this->conn->real_escape_string($product['category']);
            $price = $product['price'];
            $random_sellerid = $sellerid[array_rand($sellerid)];

            $sql = "INSERT IGNORE INTO product (productid, sellerid, name, description, image, price, category)
                    VALUES ($productid, $random_sellerid, '$name', '$description', '$image', $price, '$category')";
            $this->conn->query($sql);
        }

    }
}

new Database();
?>
