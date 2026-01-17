# Login & Signup System - MVC Architecture

A complete authentication system built with PHP following the MVC (Model-View-Controller) architectural pattern. This project demonstrates proper separation of concerns, secure password handling, and client-side validation.

---

## 📋 Table of Contents

1. [Project Overview](#project-overview)
2. [MVC Structure](#mvc-structure)
3. [Features](#features)
4. [Requirements](#requirements)
5. [Installation](#installation)
6. [Configuration](#configuration)
7. [Database Setup](#database-setup)
8. [File Descriptions](#file-descriptions)
9. [How It Works](#how-it-works)
10. [API Routes](#api-routes)
11. [Security Features](#security-features)
12. [Testing](#testing)
13. [Troubleshooting](#troubleshooting)

---

## 🎯 Project Overview

This is a **secure authentication system** built with PHP and MySQL that allows users to:
- Create a new account (Sign Up)
- Login with credentials (Login)
- Logout from their account
- Access a protected dashboard after authentication

The project follows the **MVC architectural pattern**, ensuring clean code organization and maintainability.

---

## 📁 MVC Structure

The project is organized into the following directories:

```
First_React_project/
├── index.php                    # Router - Entry point of the application
├── login.php                    # Deprecated - use index.php instead
├── dashboard.php                # Protected page (for logged-in users)
├── database_setup.sql           # Database initialization script
│
├── config/
│   └── database.php             # Database connection configuration
│
├── controllers/
│   ├── LoginController.php      # Handles login logic
│   └── SignupController.php     # Handles signup/registration logic
│
├── models/
│   └── User.php                 # User data model with database operations
│
├── views/
│   ├── login.php                # Login form view
│   └── signup.php               # Signup form view
│
└── assets/
    ├── css/
    │   └── style.css            # Global styles for login/signup pages
    └── js/
        ├── login.js             # Client-side validation for login
        └── signup.js            # Client-side validation for signup
```

### MVC Pattern Explanation

- **Model** (`models/User.php`): Handles database operations (CRUD operations, validations)
- **View** (`views/login.php`, `views/signup.php`): Displays the user interface (HTML forms)
- **Controller** (`controllers/LoginController.php`, `controllers/SignupController.php`): Processes requests and coordinates between Model and View

---

## ✨ Features

### User Authentication
- ✅ Secure password hashing using PHP's `password_hash()` with bcrypt
- ✅ Email and password validation
- ✅ Session management
- ✅ User logout functionality

### Signup Features
- ✅ Username validation (3-50 characters, alphanumeric with `-` and `_`)
- ✅ Email validation and duplicate check
- ✅ Password strength requirement (minimum 6 characters)
- ✅ Password confirmation match
- ✅ Terms and conditions acceptance

### Login Features
- ✅ Email-based login
- ✅ Password verification with bcrypt
- ✅ Remember me option (UI ready)
- ✅ Error/success message display
- ✅ Auto-hide alerts after 5 seconds

### Security
- ✅ SQL injection prevention (Prepared Statements)
- ✅ XSS protection (htmlspecialchars())
- ✅ CSRF protection ready
- ✅ Secure password hashing (bcrypt)
- ✅ Session-based authentication

### UI/UX
- ✅ Responsive design
- ✅ Modern gradient backgrounds
- ✅ Form validation (client & server-side)
- ✅ Error highlighting
- ✅ Smooth animations
- ✅ Mobile-friendly interface

---

## 📦 Requirements

- **PHP** 7.4 or higher
- **MySQL** 5.7 or higher
- **Apache** (or any web server supporting PHP)
- **XAMPP** (recommended) or similar local development environment

### Browser Compatibility
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

---

## 🚀 Installation

### Step 1: Clone/Download Project

Place the project folder in your web root directory:
- XAMPP: `C:\xampp\htdocs\First_React_project`
- WAMP: `C:\wamp\www\First_React_project`
- LAMP: `/var/www/html/First_React_project`

### Step 2: Start Your Server

1. **Start XAMPP Control Panel**
   - Click "Start" for Apache
   - Click "Start" for MySQL

2. **Verify** by opening http://localhost in your browser

### Step 3: Navigate to Project

Open: `http://localhost/First_React_project/index.php`

---

## ⚙️ Configuration

### Database Configuration

Edit `config/database.php`:

```php
class Database {
    private $host = "localhost";        // Your MySQL host
    private $db_name = "login_system";  // Your database name
    private $username = "root";         // MySQL username
    private $password = "";             // MySQL password
    public $conn;
    // ... rest of code
}
```

**Common configurations:**
- **XAMPP Default**: `$host = "localhost"`, `$username = "root"`, `$password = ""`
- **WAMP Default**: `$host = "localhost"`, `$username = "root"`, `$password = ""`
- **Remote Server**: Update host, username, and password accordingly

---

## 🗄️ Database Setup

### Method 1: Using phpMyAdmin (Easiest)

1. Open `http://localhost/phpmyadmin`
2. Click "New" to create a new database
3. Enter database name: `login_system`
4. Click "Create"
5. Select the new database
6. Click "Import" tab
7. Choose `database_setup.sql` file from your project
8. Click "Go"

### Method 2: Using MySQL Command Line

1. Open Command Prompt/Terminal
2. Navigate to your project folder
3. Run:
   ```bash
   mysql -u root -p < database_setup.sql
   ```
4. Press Enter (if no password, just press Enter again)

### Method 3: Manual SQL Execution

1. Open phpMyAdmin
2. Click "SQL" tab
3. Copy contents of `database_setup.sql`
4. Paste into the SQL editor
5. Click "Go"

### Verify Database Setup

After setup, check if the `users` table was created:

```sql
USE login_system;
SHOW TABLES;
```

You should see a `users` table with these columns:
- `id` (Primary Key)
- `username` (Unique)
- `email` (Unique)
- `password`
- `created_at`
- `updated_at`

---

## 📄 File Descriptions

### Configuration Files

#### `config/database.php`
**Purpose**: Database connection management

**Key Methods**:
- `getConnection()`: Establishes PDO connection to MySQL

**How It Works**:
```php
$database = new Database();
$conn = $database->getConnection();
// Now $conn can be used for database queries
```

---

### Controllers

#### `controllers/LoginController.php`
**Purpose**: Handles user login operations

**Key Methods**:
- `index()`: Displays the login form
- `login()`: Processes login request (POST)

**Flow**:
1. User visits `index.php?action=login`
2. Controller checks if user is already logged in
3. If logged in → redirect to dashboard
4. If not → display login form
5. User submits credentials
6. Controller validates email and password
7. If valid → create session and redirect to dashboard
8. If invalid → show error message

---

#### `controllers/SignupController.php`
**Purpose**: Handles user registration operations

**Key Methods**:
- `index()`: Displays the signup form
- `register()`: Processes signup request (POST)

**Validation**:
- Username: 3-50 characters, alphanumeric with `-` and `_`
- Email: Valid format and not already registered
- Password: Minimum 6 characters
- Confirmation: Must match password
- Terms: Must be accepted

**Flow**:
1. User visits `index.php?action=signup`
2. Controller displays signup form
3. User submits registration data
4. Server-side validation occurs
5. Check for duplicate email/username
6. Hash password and store in database
7. Redirect to login with success message
8. User can now login with new credentials

---

### Models

#### `models/User.php`
**Purpose**: Handles all user-related database operations

**Key Properties**:
```php
public $id;          // User ID (auto-generated)
public $username;    // Username (3-50 chars, unique)
public $email;       // Email (unique)
public $password;    // Password (hashed)
```

**Key Methods**:

**login()**
- Checks if email exists in database
- Verifies password with `password_verify()`
- Returns user data if successful

**register()**
- Inserts new user into database
- Hashes password with `password_hash()`
- Returns true/false

**emailExists()**
- Checks if email is already registered
- Returns true if exists, false otherwise

**usernameExists()**
- Checks if username is already taken
- Returns true if exists, false otherwise

---

### Views

#### `views/login.php`
**Purpose**: Login form UI

**Form Fields**:
- Email address
- Password
- Remember me checkbox
- Submit button

**Features**:
- Error/success message display
- Client-side validation
- Forgot password link (placeholder)
- Sign up link

**How It Works**:
1. Displays HTML form
2. Form submits to `index.php?action=login-submit`
3. JavaScript validates inputs before submission
4. Server validates on the backend

---

#### `views/signup.php`
**Purpose**: Signup form UI

**Form Fields**:
- Username
- Email address
- Password
- Confirm password
- Terms & conditions checkbox
- Submit button

**Features**:
- Real-time validation feedback
- Password strength requirements
- Terms acceptance requirement
- Link to login page

---

### Assets

#### `assets/css/style.css`
**Purpose**: Global styles for authentication pages

**Key Components**:
- `.container`: Wrapper for centered layout
- `.login-box`: Card-style form container
- `.form-group`: Form field wrapper
- `.btn-login`: Primary action button
- `.alert`: Success/error message styling
- `.error`: Error input highlighting
- Responsive media queries for mobile

**Design Features**:
- Gradient background (purple to pink)
- Smooth animations and transitions
- Focus states for accessibility
- Mobile-responsive design

---

#### `assets/js/login.js`
**Purpose**: Client-side validation for login form

**Features**:
- Email format validation
- Password requirement validation
- Real-time error display
- Form submission prevention on errors
- Auto-hide alerts after 5 seconds
- Input animation on focus

---

#### `assets/js/signup.js`
**Purpose**: Client-side validation for signup form

**Features**:
- Username validation (3-50 chars, alphanumeric)
- Email format validation
- Password strength check (6+ chars)
- Password match verification
- Terms acceptance check
- Real-time feedback
- Form submission prevention on errors

---

## 🔄 How It Works

### Complete User Flow

#### Signup Flow
```
1. User visits: http://localhost/First_React_project/index.php?action=signup
2. index.php routes to SignupController->index()
3. SignupController displays views/signup.php
4. User fills form and submits
5. Form POST to: index.php?action=register
6. SignupController->register() validates data:
   - Check required fields
   - Validate username (3-50 chars)
   - Validate email format
   - Check if email exists (query User model)
   - Check if username exists (query User model)
   - Validate password (6+ chars)
   - Check password match
7. If all valid: User->register() hashes password and inserts to DB
8. Redirect to login with success message
9. User can now login
```

#### Login Flow
```
1. User visits: http://localhost/First_React_project/index.php?action=login
2. index.php routes to LoginController->index()
3. LoginController checks if already logged in
   - If yes: redirect to dashboard.php
   - If no: display views/login.php
4. User enters email and password
5. Form POST to: index.php?action=login-submit
6. LoginController->login() validates:
   - Check required fields
   - Validate email format
7. If valid: User->login() checks database:
   - Find user by email
   - Verify password with password_verify()
8. If credentials correct:
   - Create session variables
   - Redirect to dashboard.php
9. If credentials wrong:
   - Show error message
   - Redirect back to login
```

#### Logout Flow
```
1. User clicks logout button on dashboard
2. Visits: index.php?action=logout
3. LoginController->logout() executes:
   - session_unset() - clears session data
   - session_destroy() - destroys session file
4. Redirect to index.php?action=login
5. User is now logged out
```

---

## 🌐 API Routes

### Available Routes

| Action | Method | URL | Controller | Purpose |
|--------|--------|-----|-----------|---------|
| Signup (Form) | GET | `index.php?action=signup` | SignupController->index() | Display signup form |
| Signup (Submit) | POST | `index.php?action=register` | SignupController->register() | Process registration |
| Login (Form) | GET | `index.php?action=login` | LoginController->index() | Display login form |
| Login (Submit) | POST | `index.php?action=login-submit` | LoginController->login() | Process login |
| Logout | GET | `index.php?action=logout` | LoginController->logout() | End user session |
| Default | GET | `index.php` | LoginController->index() | Redirect to login |

### Example Usage

**Access Login Page**:
```
http://localhost/First_React_project/index.php?action=login
http://localhost/First_React_project/ (default)
```

**Access Signup Page**:
```
http://localhost/First_React_project/index.php?action=signup
```

**Logout**:
```
http://localhost/First_React_project/index.php?action=logout
```

---

## 🔐 Security Features

### 1. Password Security
```php
// Hashing (Signup)
$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

// Verification (Login)
if (password_verify($this->password, $row['password'])) {
    // Password is correct
}
```
- Uses bcrypt algorithm (industry standard)
- Automatically adds salt
- Resistant to rainbow table attacks

### 2. SQL Injection Prevention
```php
// Using Prepared Statements
$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(":email", $this->email);
$stmt->execute();
```
- User input never directly inserted into queries
- Parameter binding prevents SQL injection

### 3. XSS (Cross-Site Scripting) Protection
```php
// Output escaping
echo htmlspecialchars($_SESSION['error']);
```
- All user input escaped before output
- Prevents malicious script injection

### 4. Session Management
```php
// Secure session initialization
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session storage
$_SESSION['user_id'] = $userData['id'];
$_SESSION['username'] = $userData['username'];
```
- Server-side session storage
- Session variables not exposed to client

### 5. Input Validation
- **Server-side**: All inputs validated in controllers
- **Client-side**: JavaScript validation for UX
- **Email**: Format validation and duplicate check
- **Username**: Length and character validation
- **Password**: Minimum length requirement

### 6. Database Security
- UNIQUE constraints on email and username
- Prepared statements for all queries
- Proper error handling without exposing details

---

## 🧪 Testing

### Test Account Credentials

After database setup, use these test credentials:

**Username**: `testuser`  
**Email**: `test@example.com`  
**Password**: `password123`

### Test Cases

#### Signup Tests
1. **Valid Registration**
   - Enter valid username, email, password
   - Expected: Account created, redirect to login

2. **Duplicate Email**
   - Try to register with existing email
   - Expected: Error message shown

3. **Duplicate Username**
   - Try to register with existing username
   - Expected: Error message shown

4. **Short Username** (< 3 chars)
   - Enter 1-2 character username
   - Expected: Error message shown

5. **Invalid Email**
   - Enter text without @ symbol
   - Expected: Error message shown

6. **Password Mismatch**
   - Enter different passwords in both fields
   - Expected: Error message shown

#### Login Tests
1. **Valid Credentials**
   - Enter test email and password
   - Expected: Logged in, redirect to dashboard

2. **Invalid Email**
   - Enter email not in database
   - Expected: Error message

3. **Wrong Password**
   - Enter correct email with wrong password
   - Expected: Error message

4. **Empty Fields**
   - Submit form without entering anything
   - Expected: Validation error

#### Session Tests
1. **Logged In Access**
   - Login successfully, open dashboard
   - Expected: Can view dashboard, see username

2. **Logout**
   - Click logout button
   - Expected: Session cleared, redirect to login

3. **Direct Access Without Login**
   - Try to access dashboard directly
   - Expected: Redirected to login (if session protection added)

---

## 🐛 Troubleshooting

### Database Connection Error

**Error**: "Connection Error: SQLSTATE[HY000]"

**Solutions**:
1. Verify MySQL is running (XAMPP Control Panel)
2. Check database credentials in `config/database.php`
3. Ensure database is created (run `database_setup.sql`)
4. Check database name matches in config

**Test Connection**:
```php
<?php
$database = new Database();
$conn = $database->getConnection();
if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}
?>
```

---

### Password Not Working on Login

**Solutions**:
1. Check if user was created with current system (older hashes may use different algorithm)
2. Regenerate user with new password:
   ```sql
   UPDATE users SET password = '$2y$10$...' WHERE email = 'user@example.com';
   ```
3. Use test account (testuser@example.com / password123)

---

### Sessions Not Persisting

**Solutions**:
1. Verify `session_start()` is called on every page
2. Check if cookies are enabled in browser
3. Clear browser cookies and try again
4. Check PHP session save path is writable

---

### Forms Not Submitting

**Solutions**:
1. Check browser console for JavaScript errors
2. Verify form `action` attribute is correct
3. Check form `method` is POST
4. Disable JavaScript to test server-side only
5. Check if validation is preventing submission

---

### CSS/JS Not Loading

**Solutions**:
1. Check file paths are relative (use `assets/css/style.css`)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Check files exist in correct directories
4. Verify file permissions (readable)
5. Check browser console for 404 errors

---

### Database Table Not Found

**Error**: "SQLSTATE[42S02]: Table 'login_system.users' doesn't exist"

**Solutions**:
1. Run `database_setup.sql` again
2. Verify database name is correct
3. Check if table exists in phpMyAdmin
4. Manually create table:
   ```sql
   USE login_system;
   CREATE TABLE IF NOT EXISTS users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       email VARCHAR(100) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

---

### Port Already in Use

**Error**: "Port 3306 or 80 already in use"

**Solutions**:
1. Change XAMPP port in Apache settings
2. Kill process using the port
3. Use different port: `http://localhost:8080/...`
4. Check in XAMPP Config which port is selected

---

## 📚 Additional Resources

### PHP Documentation
- [PHP Official Documentation](https://www.php.net/docs.php)
- [PDO (PHP Data Objects)](https://www.php.net/manual/en/book.pdo.php)
- [Password Hashing](https://www.php.net/manual/en/function.password-hash.php)
- [Sessions](https://www.php.net/manual/en/book.session.php)

### MySQL Documentation
- [MySQL Official Documentation](https://dev.mysql.com/doc/)
- [MySQL Tutorial](https://www.w3schools.com/sql/)

### Web Security
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [SQL Injection Prevention](https://owasp.org/www-community/attacks/SQL_Injection)
- [XSS Prevention](https://owasp.org/www-community/attacks/xss/)

---

## 🎓 Learning Points

This project demonstrates:

1. **MVC Architecture**: Separation of concerns
2. **Database Security**: Prepared statements, password hashing
3. **Session Management**: User authentication
4. **Client-Server Validation**: Double-layer security
5. **Responsive Design**: Mobile-friendly UI
6. **PHP Best Practices**: Clean code, proper error handling
7. **Form Handling**: POST requests, data validation
8. **Object-Oriented Programming**: Classes, methods, properties

---

## 📝 License

This project is open-source and available for educational purposes.

---

## 👨‍💻 Author Notes

This is a **beginner-friendly** authentication system that emphasizes:
- Clean, readable code
- Security best practices
- Proper project structure
- Comprehensive documentation

**Perfect for learning**:
- PHP fundamentals
- MVC pattern
- Database operations
- User authentication
- Web security basics

---

## 🤝 Support

For issues or questions:
1. Check the troubleshooting section above
2. Verify all steps in installation
3. Check browser console for errors
4. Check PHP error logs

---

## ✅ Checklist for Setup

- [ ] XAMPP/Web server installed
- [ ] PHP 7.4+ installed
- [ ] MySQL running
- [ ] Project files in web root
- [ ] Database created (login_system)
- [ ] Users table created
- [ ] Database credentials correct in `config/database.php`
- [ ] Tested signup with valid data
- [ ] Tested login with test account
- [ ] Tested logout functionality
- [ ] Verified responsive design on mobile

---

**Happy Coding! 🚀**
