<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - MVC Pattern</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Welcome Back!</h1>
            <p class="subtitle">Please login to your account</p>

            <?php
            // Display error messages
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }

            // Display success messages
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form id="loginForm" action="index.php?action=login-submit" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your email"
                        required
                    >
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        required
                    >
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <label class="checkbox">
                        <input type="checkbox" id="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="divider">
                <span>OR</span>
            </div>

            <p class="signup-text">
                Don't have an account? <a href="index.php?action=signup">Sign Up</a>
            </p>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
</body>
</html>
