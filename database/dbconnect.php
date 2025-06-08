<?php

class Database{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "market";
    public $conn;

    function __construct()
    {
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        } catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>