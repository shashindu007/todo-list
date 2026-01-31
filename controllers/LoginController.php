<?php
/**
 * Login Controller
 * Handles login and registration requests
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class LoginController {
    private $db;
    private $user;

    /**
     * Constructor
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    /**
     * Show login page
     */
    public function index() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header("Location: dashboard.php");
            exit();
        }

        require_once __DIR__ . '/../views/login.php';
    }

    /**
     * Handle login request
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get POST data
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            // Validate input
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "All fields are required";
                header("Location: index.php?action=login");
                exit();
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format";
                header("Location: index.php?action=login");
                exit();
            }

            // Set user properties
            $this->user->email = $email;
            $this->user->password = $password;

            // Attempt login
            $userData = $this->user->login();

            if ($userData) {
                // Login successful
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];
                $_SESSION['email'] = $userData['email'];
                $_SESSION['success'] = "Login successful!";
                
                header("Location: dashboard.php");
                exit();
            } else {
                // Login failed
                $_SESSION['error'] = "Invalid email or password";
                header("Location: index.php?action=login");
                exit();
            }
        }
    }

    /**
     * Handle logout request
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        
        header("Location: index.php");
        exit();
    }
}
?>
