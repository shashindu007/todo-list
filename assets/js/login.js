/**
 * Login Form JavaScript
 * Handles client-side form validation and user interactions
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    /**
     * Validate email format
     * @param {string} email - Email address to validate
     * @returns {boolean} - True if valid, false otherwise
     */
    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    /**
     * Validate password
     * @param {string} password - Password to validate
     * @returns {boolean} - True if valid, false otherwise
     */
    function validatePassword(password) {
        return password.length >= 6;
    }

    /**
     * Show error message
     * @param {HTMLElement} input - Input element
     * @param {HTMLElement} errorElement - Error message element
     * @param {string} message - Error message
     */
    function showError(input, errorElement, message) {
        input.classList.add('error');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    /**
     * Clear error message
     * @param {HTMLElement} input - Input element
     * @param {HTMLElement} errorElement - Error message element
     */
    function clearError(input, errorElement) {
        input.classList.remove('error');
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }

    /**
     * Real-time email validation
     */
    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        
        if (email === '') {
            showError(emailInput, emailError, 'Email is required');
        } else if (!validateEmail(email)) {
            showError(emailInput, emailError, 'Please enter a valid email address');
        } else {
            clearError(emailInput, emailError);
        }
    });

    /**
     * Real-time password validation
     */
    passwordInput.addEventListener('blur', function() {
        const password = this.value;
        
        if (password === '') {
            showError(passwordInput, passwordError, 'Password is required');
        } else if (!validatePassword(password)) {
            showError(passwordInput, passwordError, 'Password must be at least 6 characters');
        } else {
            clearError(passwordInput, passwordError);
        }
    });

    /**
     * Clear errors on input
     */
    emailInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            clearError(emailInput, emailError);
        }
    });

    passwordInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            clearError(passwordInput, passwordError);
        }
    });

    /**
     * Form submission validation
     */
    loginForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Clear previous errors
        clearError(emailInput, emailError);
        clearError(passwordInput, passwordError);

        // Validate email
        const email = emailInput.value.trim();
        if (email === '') {
            showError(emailInput, emailError, 'Email is required');
            isValid = false;
        } else if (!validateEmail(email)) {
            showError(emailInput, emailError, 'Please enter a valid email address');
            isValid = false;
        }

        // Validate password
        const password = passwordInput.value;
        if (password === '') {
            showError(passwordInput, passwordError, 'Password is required');
            isValid = false;
        } else if (!validatePassword(password)) {
            showError(passwordInput, passwordError, 'Password must be at least 6 characters');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
            return false;
        }

        // Optional: Show loading state
        const submitButton = loginForm.querySelector('.btn-login');
        submitButton.textContent = 'Logging in...';
        submitButton.disabled = true;
    });

    /**
     * Auto-hide alerts after 5 seconds
     */
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });

    /**
     * Add animation to inputs on focus
     */
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
            this.parentElement.style.transition = 'transform 0.2s';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
});
