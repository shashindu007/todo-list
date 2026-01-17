# Quick Reference Guide - MVC Login & Signup System

## 🎯 Project Overview

This is a complete PHP authentication system with signup and login functionality, organized using the **MVC (Model-View-Controller)** architectural pattern.

---

## 📁 MVC Structure at a Glance

```
MODEL (data layer)          CONTROLLER (logic)          VIEW (display)
│                           │                           │
└─ User.php                 └─ LoginController.php      └─ login.php
   - login()                   - index()                   - form
   - register()                - login()                   - styling
   - emailExists()             - logout()
   - usernameExists()
                            └─ SignupController.php     └─ signup.php
                               - index()                   - form
                               - register()                - styling
```

---

## 🔄 How Data Flows (Signup Example)

```
User submits signup form
        ↓
index.php?action=register routes to SignupController
        ↓
SignupController->register() validates input
        ↓
User model->register() hashes password & inserts to DB
        ↓
Redirect to login page with success message
        ↓
User can now login
```

---

## 🌐 Available Routes

| URL | Action | Result |
|-----|--------|--------|
| `/` or `/?action=login` | Display login form | Show login page |
| `/?action=signup` | Display signup form | Show signup page |
| `/?action=login-submit` | Process login (POST) | Authenticate user |
| `/?action=register` | Process signup (POST) | Create account |
| `/?action=logout` | Logout | Destroy session |

---

## 🔐 Security At Work

### Password Security
```php
// When registering:
password_hash($password, PASSWORD_DEFAULT)  // Creates bcrypt hash

// When logging in:
password_verify($password, $hashedPassword)  // Compares safely
```

### SQL Safety
```php
// Good (Protected):
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

// Bad (Vulnerable):
$query = "SELECT * FROM users WHERE email = '$email'";
```

### Output Safety
```php
// Good (Protected):
echo htmlspecialchars($userInput);

// Bad (Vulnerable):
echo $userInput;  // Could execute JavaScript
```

---

## 📋 Validation Rules

### Signup Form
| Field | Rules | Example |
|-------|-------|---------|
| **Username** | 3-50 chars, alphanumeric `-` `_` | `john_doe-123` |
| **Email** | Valid email format | `john@example.com` |
| **Password** | Minimum 6 chars | `MyP@ss123` |
| **Confirm** | Must match password | Same as password |
| **Terms** | Must be checked | ✓ Checked |

### Login Form
| Field | Rules | Example |
|-------|-------|---------|
| **Email** | Valid email format | `john@example.com` |
| **Password** | Minimum 1 char | `MyP@ss123` |

---

## 📊 Database Schema

```sql
Table: users
├── id (PRIMARY KEY)
├── username (UNIQUE)
├── email (UNIQUE)
├── password (hashed)
├── created_at (timestamp)
└── updated_at (timestamp)
```

**Test User**:
```
username: testuser
email: test@example.com
password: password123 (hashed as: $2y$10$...)
```

---

## 🚀 Quick Setup Checklist

- [ ] Download/clone project to htdocs folder
- [ ] Start Apache and MySQL (XAMPP Control Panel)
- [ ] Open phpMyAdmin (http://localhost/phpmyadmin)
- [ ] Import database_setup.sql file
- [ ] Update config/database.php if needed (usually no changes)
- [ ] Visit http://localhost/First_React_project/
- [ ] Test signup with new account
- [ ] Test login with credentials
- [ ] Test logout

---

## 📝 File Purposes

| File | Purpose | What It Does |
|------|---------|--------------|
| **index.php** | Router | Routes requests to correct controller |
| **config/database.php** | Configuration | Connects to MySQL database |
| **models/User.php** | Data | Handles user database operations |
| **controllers/LoginController.php** | Logic | Manages login process |
| **controllers/SignupController.php** | Logic | Manages registration |
| **views/login.php** | Display | Shows login form |
| **views/signup.php** | Display | Shows signup form |
| **assets/css/style.css** | Styling | CSS for both forms |
| **assets/js/login.js** | Validation | Client-side form checking |
| **assets/js/signup.js** | Validation | Client-side form checking |

---

## 🔍 Common Tasks

### Change Database Credentials
**File**: `config/database.php`
```php
private $host = "localhost";      // Your host
private $db_name = "login_system"; // Your database name
private $username = "root";        // Your username
private $password = "";            // Your password
```

### Add New Validation Rule
**File**: `controllers/SignupController.php` (in `register()` method)
```php
// Example: Check minimum age
if ($age < 18) {
    $_SESSION['error'] = "You must be 18 or older";
    header("Location: index.php?action=signup");
    exit();
}
```

### Modify Form Fields
**File**: `views/signup.php` (add new input field)
```php
<div class="form-group">
    <label for="fieldname">Field Label</label>
    <input type="text" id="fieldname" name="fieldname">
</div>
```

### Change Styling
**File**: `assets/css/style.css`
```css
/* Example: Change button color */
.btn-login {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* Change #667eea and #764ba2 to your colors */
}
```

---

## 🐛 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| "Database connection failed" | Check MySQL is running in XAMPP |
| "Table doesn't exist" | Run database_setup.sql in phpMyAdmin |
| "Login fails with correct password" | Use test account (test@example.com) |
| "Forms not validating" | Check browser console (F12 Dev Tools) |
| "CSS/JS not loading" | Clear cache (Ctrl+Shift+Delete) |
| "Session not working" | Verify session_start() is called |

---

## 🎓 What Each File Does

### **index.php** (Router)
Decides which controller to use based on URL action parameter.

```php
if ($action == 'signup') {
    use SignupController
} else if ($action == 'login') {
    use LoginController
}
```

### **User.php** (Model)
Talks to the database:
- `login()` - Finds user and verifies password
- `register()` - Creates new user account
- `emailExists()` - Checks if email is taken
- `usernameExists()` - Checks if username is taken

### **LoginController.php** (Controller)
Handles login requests:
1. Show login form on GET request
2. Validate input on POST request
3. Call User model to check credentials
4. Redirect to dashboard or show error

### **SignupController.php** (Controller)
Handles signup requests:
1. Show signup form on GET request
2. Validate all input on POST request
3. Check for duplicates via User model
4. Create new user via User model
5. Redirect to login with success message

### **views/login.php** & **views/signup.php** (Views)
Just displays HTML forms. No business logic here.

### **login.js** & **signup.js** (Client-side Validation)
Validates form before sending to server:
- Checks required fields
- Validates email format
- Checks password length
- Shows error messages

---

## 🔐 Security Quick Check

✅ **Passwords**: Hashed with bcrypt (cannot be reversed)  
✅ **Queries**: Use prepared statements (safe from SQL injection)  
✅ **Output**: Escaped with htmlspecialchars() (safe from XSS)  
✅ **Sessions**: Server-side only (can't be modified by user)  
✅ **Duplicates**: UNIQUE constraints + application checks  
✅ **Validation**: Client-side (for UX) + Server-side (for security)

---

## 📚 Key Concepts

**MVC Pattern**: Separates code into three layers
- **Model**: Data/database
- **View**: Display/UI
- **Controller**: Logic/processing

**Prepared Statements**: Prevents SQL injection by separating code from data

**Password Hashing**: One-way encryption that can't be reversed

**Sessions**: Server remembers logged-in users across page loads

**Validation**: Checking data is correct (both on client and server)

---

## 🎯 Learning Objectives

After studying this project, you'll understand:
- ✅ How MVC architecture works
- ✅ How user authentication works
- ✅ How to hash passwords securely
- ✅ How to prevent SQL injection
- ✅ How to validate user input
- ✅ How to manage user sessions
- ✅ How to organize a PHP project
- ✅ How to handle forms in PHP

---

## 📞 Quick Links

- **Check Security**: Look at prepared statements in User.php
- **See Validation**: Check LoginController.php and SignupController.php
- **Modify Form**: Edit views/login.php or views/signup.php
- **Change Styling**: Edit assets/css/style.css
- **Add Logic**: Edit controllers/LoginController.php or controllers/SignupController.php

---

## ✨ Success Indicators

- [ ] Can visit signup page
- [ ] Can create new account
- [ ] Can login with new account
- [ ] See username on dashboard
- [ ] Can logout
- [ ] Error messages appear for invalid input
- [ ] Form validation works on client & server
- [ ] Can't login with wrong password

---

## 🚀 Next Steps

1. **Test thoroughly** - Try all the test cases in README.md
2. **Understand the code** - Read each file and understand how it works
3. **Modify styling** - Change colors, fonts, layout
4. **Add features** - Password reset, email verification, etc.
5. **Improve security** - Add CSRF tokens, rate limiting, 2FA
6. **Deploy** - Move to production server with HTTPS

---

## 📖 For More Details

Check **README.md** for:
- Complete installation guide
- Detailed file descriptions
- Security explanations
- Troubleshooting guide
- Testing guidelines

---

**You now have a professional, secure authentication system! 🎉**
