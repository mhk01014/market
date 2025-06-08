<?php
require_once 'database/dbconnect.php';
class Users
{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conn;
    }

    //function to check login credentials
    public function login($name, $password)
    {
        $sql = "SELECT * FROM users WHERE name = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) 
        {
            if ($user['status'] == 'active' && password_verify($password, $user['password'])) 
            {
                return $user;
            }   return false;
        } return false;
    }

    //function to check if user exists
    private function userExists($name)
    {
        $sql = "SELECT userid FROM users WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    //function to register user
    public function register($name, $password, $role)
    {
        if ($this->userExists($name)) {
            return false; // duplicate name
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, password, role, status) 
                        VALUES (?, ?, ?, 'active')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $hashedPassword, $role);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    //function to update the register user
    public function update($userid, $name, $password, $role)
    {
        $sql = "SELECT password FROM users WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        $currentHashedPassword = $user['password'];

        // Check if user entered the same password or a new one
        if (password_verify($password, $currentHashedPassword)) 
        {
            $hashedPassword = $currentHashedPassword;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql = "UPDATE users SET name = ?, password = ?, role = ?
                WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $hashedPassword, $role, $userid);
        $stmt->execute();
    }

    //function to delete the register user
    public function delete($userid)
    {
        $sql = "DELETE FROM users WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
    }

    //function to approve the register user
    public function approve($userid)
    {
        $sql = "UPDATE users SET status = 'active' WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
    }

    //function to search user
    public function search($name)
    {
        $name = '%' . $name . '%';
        $sql = "SELECT * FROM users WHERE name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    //function to view user
    public function view($userid)
    {
        $sql = "SELECT * FROM users WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    //function to get all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    //function to logout
    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_unset();
        session_destroy();
        exit();
    }
}
?>