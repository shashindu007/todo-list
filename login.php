<?php
/**
 * Entry Point - index.php
 * This file handles routing and initializes the application
 */

// Include the LoginController
require_once __DIR__ . '/controllers/LoginController.php';

// Create controller instance
$controller = new LoginController();

// Get the action from URL parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate controller method
switch ($action) {
    case 'login':
        $controller->login();
        break;
    
    case 'logout':
        $controller->logout();
        break;
    
    default:
        $controller->index();
        break;
}
?>
