<?php
/**
 * Router - index.php
 * This file handles routing and initializes the application
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the action from URL parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Route to appropriate controller
switch ($action) {
    case 'signup':
        require_once __DIR__ . '/controllers/SignupController.php';
        $controller = new SignupController();
        $controller->index();
        break;
    
    case 'register':
        require_once __DIR__ . '/controllers/SignupController.php';
        $controller = new SignupController();
        $controller->register();
        break;
    
    case 'login':
        require_once __DIR__ . '/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->index();
        break;
    
    case 'login-submit':
        require_once __DIR__ . '/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->login();
        break;
    
    case 'logout':
        require_once __DIR__ . '/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->logout();
        break;
    
    default:
        require_once __DIR__ . '/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->index();
        break;
}
?>
