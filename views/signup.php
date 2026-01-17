<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Create Account</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Create Account</h1>
            <p class="subtitle">Join us today and get started</p>

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

            <form id="signupForm" action="index.php?action=register" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Choose a username"
                        required
                        minlength="3"
                        maxlength="50"
                    >
                    <span class="error-message" id="usernameError"></span>
                </div>

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
                        placeholder="Create a strong password"
                        required
                        minlength="6"
                    >
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        placeholder="Re-enter your password"
                        required
                        minlength="6"
                    >
                    <span class="error-message" id="confirmPasswordError"></span>
                </div>

                <div class="form-options">
                    <label class="checkbox">
                        <input type="checkbox" id="terms" required>
                        <span>I agree to the Terms & Conditions</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">Sign Up</button>
            </form>

            <div class="divider">
                <span>OR</span>
            </div>

            <p class="signup-text">
                Already have an account? <a href="index.php?action=login">Login Here</a>
            </p>
        </div>
    </div>

    <script src="assets/js/signup.js"></script>
</body>
</html>
