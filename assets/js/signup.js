/**
 * Signup Form Validation
 * Handles client-side validation for signup form
 */

document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const terms = document.getElementById('terms');

    // Real-time validation
    username.addEventListener('blur', validateUsername);
    email.addEventListener('blur', validateEmail);
    password.addEventListener('blur', validatePassword);
    confirmPassword.addEventListener('blur', validatePasswordMatch);
    terms.addEventListener('change', validateTerms);

    // Form submission
    signupForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset error messages
        resetErrors();

        // Validate all fields
        const isUsernameValid = validateUsername();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isPasswordMatchValid = validatePasswordMatch();
        const isTermsValid = validateTerms();

        if (isUsernameValid && isEmailValid && isPasswordValid && isPasswordMatchValid && isTermsValid) {
            signupForm.submit();
        }
    });

    /**
     * Validate username
     */
    function validateUsername() {
        const usernameError = document.getElementById('usernameError');
        const value = username.value.trim();

        if (value === '') {
            showError(username, usernameError, 'Username is required');
            return false;
        }

        if (value.length < 3) {
            showError(username, usernameError, 'Username must be at least 3 characters');
            return false;
        }

        if (value.length > 50) {
            showError(username, usernameError, 'Username must not exceed 50 characters');
            return false;
        }

        if (!/^[a-zA-Z0-9_-]+$/.test(value)) {
            showError(username, usernameError, 'Username can only contain letters, numbers, underscores, and hyphens');
            return false;
        }

        clearError(username, usernameError);
        return true;
    }

    /**
     * Validate email
     */
    function validateEmail() {
        const emailError = document.getElementById('emailError');
        const value = email.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value === '') {
            showError(email, emailError, 'Email is required');
            return false;
        }

        if (!emailRegex.test(value)) {
            showError(email, emailError, 'Please enter a valid email address');
            return false;
        }

        clearError(email, emailError);
        return true;
    }

    /**
     * Validate password
     */
    function validatePassword() {
        const passwordError = document.getElementById('passwordError');
        const value = password.value;

        if (value === '') {
            showError(password, passwordError, 'Password is required');
            return false;
        }

        if (value.length < 6) {
            showError(password, passwordError, 'Password must be at least 6 characters');
            return false;
        }

        clearError(password, passwordError);
        return true;
    }

    /**
     * Validate password match
     */
    function validatePasswordMatch() {
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        const passwordValue = password.value;
        const confirmValue = confirmPassword.value;

        if (confirmValue === '') {
            showError(confirmPassword, confirmPasswordError, 'Please confirm your password');
            return false;
        }

        if (passwordValue !== confirmValue) {
            showError(confirmPassword, confirmPasswordError, 'Passwords do not match');
            return false;
        }

        clearError(confirmPassword, confirmPasswordError);
        return true;
    }

    /**
     * Validate terms acceptance
     */
    function validateTerms() {
        const termsError = document.getElementById('termsError');
        
        if (!terms.checked) {
            if (!termsError) {
                const errorSpan = document.createElement('span');
                errorSpan.id = 'termsError';
                errorSpan.className = 'error-message';
                errorSpan.textContent = 'You must agree to the terms and conditions';
                terms.parentElement.appendChild(errorSpan);
            }
            return false;
        }

        const termsErrorEl = document.getElementById('termsError');
        if (termsErrorEl) {
            termsErrorEl.remove();
        }
        return true;
    }

    /**
     * Show error message
     */
    function showError(input, errorElement, message) {
        input.classList.add('error');
        errorElement.textContent = message;
    }

    /**
     * Clear error message
     */
    function clearError(input, errorElement) {
        input.classList.remove('error');
        errorElement.textContent = '';
    }

    /**
     * Reset all error messages
     */
    function resetErrors() {
        document.querySelectorAll('input').forEach(input => {
            input.classList.remove('error');
        });
        document.querySelectorAll('.error-message').forEach(error => {
            error.textContent = '';
        });
    }
});
