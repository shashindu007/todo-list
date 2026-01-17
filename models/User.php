<?php
/**
 * User Model
 * Handles all user-related database operations
 */

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;

    /**
     * Constructor
     * @param PDO $db Database connection
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Login user
     * @return bool|array Returns user data if successful, false otherwise
     */
    public function login() {
        $query = "SELECT id, username, email, password 
                  FROM " . $this->table_name . " 
                  WHERE email = :email 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            
            // Verify password
            if (password_verify($this->password, $row['password'])) {
                return $row;
            }
        }
        
        return false;
    }

    /**
     * Register new user
     * @return bool
     */
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (username, email, password) 
                  VALUES (:username, :email, :password)";

        $stmt = $this->conn->prepare($query);

        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Check if email exists
     * @return bool
     */
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE email = :email 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Check if username exists
     * @return bool
     */
    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>
