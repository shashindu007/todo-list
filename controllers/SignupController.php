<?php
/**
 * Signup Controller
 * Handles user registration requests
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class SignupController {
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
     * Show signup page
     */
    public function index() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header("Location: dashboard.php");
            exit();
        }

        require_once __DIR__ . '/../views/signup.php';
    }

    /**
     * Handle signup request
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get POST data
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

            // Validate input
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['error'] = "All fields are required";
                header("Location: index.php?action=signup");
                exit();
            }

            // Validate username length
            if (strlen($username) < 3 || strlen($username) > 50) {
                $_SESSION['error'] = "Username must be between 3 and 50 characters";
                header("Location: index.php?action=signup");
                exit();
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format";
                header("Location: index.php?action=signup");
                exit();
            }

            // Validate password strength
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters";
                header("Location: index.php?action=signup");
                exit();
            }

            // Check if passwords match
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match";
                header("Location: index.php?action=signup");
                exit();
            }

            // Set user properties
            $this->user->username = $username;
            $this->user->email = $email;
            $this->user->password = $password;

            // Check if email already exists
            if ($this->user->emailExists()) {
                $_SESSION['error'] = "Email already registered";
                header("Location: index.php?action=signup");
                exit();
            }

            // Check if username already exists
            if ($this->user->usernameExists()) {
                $_SESSION['error'] = "Username already taken";
                header("Location: index.php?action=signup");
                exit();
            }

            // Attempt registration
            if ($this->user->register()) {
                $_SESSION['success'] = "Account created successfully! Please login with your credentials.";
                header("Location: index.php?action=login");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
                header("Location: index.php?action=signup");
                exit();
            }
        }
    }
}
?>
