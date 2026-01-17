# Visual Code Flow Guide - MVC Authentication System

## 🎯 User Registration Flow (Signup)

```
┌─────────────────────────────────────────────────────────────────────┐
│                        USER SIGNUP FLOW                            │
└─────────────────────────────────────────────────────────────────────┘

1. USER VISITS SIGNUP PAGE
   └─ URL: http://localhost/First_React_project/index.php?action=signup

2. INDEX.PHP (Router)
   ├─ Reads action parameter: "signup"
   └─ Routes to: SignupController->index()

3. SIGNUPCONTROLLER->INDEX()
   ├─ Check if already logged in
   ├─ If yes: Redirect to dashboard
   └─ If no: Load views/signup.php

4. SIGNUP.PHP (View - HTML Form)
   ├─ Displays form with fields:
   │  ├─ Username (text input)
   │  ├─ Email (email input)
   │  ├─ Password (password input)
   │  ├─ Confirm Password (password input)
   │  └─ Terms checkbox
   ├─ Loads signup.js for validation
   └─ Form action: index.php?action=register (POST)

5. USER FILLS FORM & CLICKS SUBMIT
   └─ signup.js validates form data:
      ├─ Username: 3-50 chars, alphanumeric
      ├─ Email: Valid format
      ├─ Password: 6+ characters
      ├─ Confirm: Matches password
      └─ Terms: Must be checked
      
   If validation FAILS:
   └─ Show error messages (red text)
      └─ User cannot submit
   
   If validation PASSES:
   └─ Allow form submission

6. FORM SUBMITS TO SERVER (POST)
   └─ URL: index.php?action=register
   └─ Data sent: { username, email, password, confirm_password, terms }

7. INDEX.PHP (Router)
   ├─ Reads action: "register"
   └─ Routes to: SignupController->register()

8. SIGNUPCONTROLLER->REGISTER() (Business Logic)
   ├─ Get POST data
   ├─ Server-side validation:
   │  ├─ Check all fields required
   │  ├─ Check username 3-50 chars
   │  ├─ Check email valid format
   │  ├─ Check password 6+ chars
   │  ├─ Check passwords match
   │  ├─ Check email not duplicate
   │  └─ Check username not duplicate
   │
   ├─ If validation FAILS:
   │  ├─ Set $_SESSION['error']
   │  ├─ Redirect to signup page
   │  └─ Show error to user
   │
   └─ If validation PASSES:
      └─ Call User model: register()

9. USER.PHP->REGISTER() (Database Operation)
   ├─ Hash password: password_hash()
   ├─ Prepare SQL INSERT statement
   ├─ Execute: INSERT INTO users (...)
   └─ Return: true/false

10. BACK TO SIGNUPCONTROLLER
    ├─ If registration successful:
    │  ├─ Set $_SESSION['success']
    │  ├─ Redirect to login page
    │  └─ Show success message
    │
    └─ If registration failed:
       ├─ Set $_SESSION['error']
       ├─ Redirect back to signup
       └─ Show error message

11. USER SEES LOGIN PAGE
    ├─ "Account created successfully!"
    └─ Can now login with:
       ├─ Email: (entered email)
       └─ Password: (entered password)
```

---

## 🔐 User Login Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                         USER LOGIN FLOW                            │
└─────────────────────────────────────────────────────────────────────┘

1. USER VISITS LOGIN PAGE
   └─ URL: http://localhost/First_React_project/

2. INDEX.PHP (Router)
   ├─ Reads action parameter (none/login)
   └─ Routes to: LoginController->index()

3. LOGINCONTROLLER->INDEX()
   ├─ Check if already logged in via $_SESSION['user_id']
   ├─ If yes (already logged in):
   │  └─ Redirect to dashboard.php
   │
   └─ If no (not logged in):
      └─ Load views/login.php

4. LOGIN.PHP (View - HTML Form)
   ├─ Displays form with fields:
   │  ├─ Email (email input)
   │  ├─ Password (password input)
   │  └─ Remember me (checkbox)
   ├─ Loads login.js for validation
   └─ Form action: index.php?action=login-submit (POST)

5. USER ENTERS CREDENTIALS & CLICKS LOGIN
   └─ login.js validates form data:
      ├─ Email: Valid format required
      └─ Password: Not empty required
      
   If validation FAILS:
   └─ Show error messages
   
   If validation PASSES:
   └─ Allow form submission

6. FORM SUBMITS TO SERVER (POST)
   └─ URL: index.php?action=login-submit
   └─ Data sent: { email, password }

7. INDEX.PHP (Router)
   ├─ Reads action: "login-submit"
   └─ Routes to: LoginController->login()

8. LOGINCONTROLLER->LOGIN() (Business Logic)
   ├─ Check request method is POST
   ├─ Get email and password from POST
   ├─ Validate:
   │  ├─ Both fields required
   │  └─ Email format valid
   │
   ├─ If validation FAILS:
   │  ├─ Set error message
   │  └─ Redirect to login page
   │
   └─ If validation PASSES:
      └─ Call User model: login()

9. USER.PHP->LOGIN() (Database Authentication)
   ├─ Prepare SQL SELECT statement
   ├─ Find user by email in database
   ├─ If user NOT found:
   │  └─ Return false
   │
   └─ If user IS found:
      ├─ Get hashed password from database
      ├─ Verify: password_verify(input_password, db_password)
      ├─ If password WRONG:
      │  └─ Return false
      │
      └─ If password CORRECT:
         └─ Return user data (id, username, email)

10. BACK TO LOGINCONTROLLER
    ├─ Check if User->login() returned data
    ├─ If false (authentication failed):
    │  ├─ Set $_SESSION['error'] = "Invalid email or password"
    │  ├─ Redirect to login page
    │  └─ User sees error message
    │
    └─ If success (user data returned):
       ├─ Create session variables:
       │  ├─ $_SESSION['user_id'] = user_id
       │  ├─ $_SESSION['username'] = username
       │  └─ $_SESSION['email'] = email
       ├─ Set success message
       ├─ Redirect to dashboard.php
       └─ User is now LOGGED IN

11. DASHBOARD.PHP
    ├─ Check if $_SESSION['user_id'] exists
    ├─ If not: Should redirect to login (optional)
    └─ If yes:
       ├─ Display: "Welcome, {username}!"
       ├─ Show user information
       └─ Show logout button
```

---

## 🚪 User Logout Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                         USER LOGOUT FLOW                           │
└─────────────────────────────────────────────────────────────────────┘

1. USER CLICKS LOGOUT BUTTON
   └─ Link: index.php?action=logout

2. INDEX.PHP (Router)
   ├─ Reads action: "logout"
   └─ Routes to: LoginController->logout()

3. LOGINCONTROLLER->LOGOUT()
   ├─ Call session_unset()     (Clear all session data)
   ├─ Call session_destroy()   (Destroy session file)
   ├─ Redirect to index.php
   └─ User is now LOGGED OUT

4. BROWSER REDIRECTS TO LOGIN PAGE
   └─ $_SESSION is now empty
   └─ User sees login form
```

---

## 📊 Database Operations Diagram

```
┌──────────────────────────────────────────────────────────────────┐
│                   DATABASE OPERATIONS                            │
└──────────────────────────────────────────────────────────────────┘

USERS TABLE
┌─────────────────────────────────────────────────────────┐
│ id │ username │ email          │ password (hashed)     │
├────┼──────────┼────────────────┼──────────────────────┤
│ 1  │ testuser │ test@ex.com    │ $2y$10$92IXUNpkjO... │
│ 2  │ john_doe │ john@ex.com    │ $2y$10$a8bC2De3fG...  │
│ 3  │ jane123  │ jane@ex.com    │ $2y$10$xYzAbCdEfG...  │
└─────────────────────────────────────────────────────────┘

SIGNUP - INSERT NEW USER
   Input: username, email, password
   ↓
   Hash password with password_hash()
   ↓
   INSERT INTO users (username, email, password)
   ↓
   New user added to database

LOGIN - FIND & VERIFY USER
   Input: email, password
   ↓
   SELECT password FROM users WHERE email = ?
   ↓
   Use password_verify() to compare:
      - Input password
      - Database hashed password
   ↓
   If match: User authenticated ✓
   If no match: Authentication failed ✗
```

---

## 🔐 Password Hashing Diagram

```
┌──────────────────────────────────────────────────────────────────┐
│                    PASSWORD SECURITY                             │
└──────────────────────────────────────────────────────────────────┘

SIGNUP - HASHING
   User enters: "MyPassword123"
   ↓
   PHP function: password_hash("MyPassword123", PASSWORD_DEFAULT)
   ↓
   Creates unique hash: $2y$10$a1b2c3d4e5f6g7h8i9j0k...
   ↓
   Stored in database (NOT the original password!)
   ↓
   Original password is DELETED (only hash stored)

LOGIN - VERIFICATION
   User enters: "MyPassword123"
   ↓
   Fetch hash from database: $2y$10$a1b2c3d4e5f6g7h8i9j0k...
   ↓
   PHP function: password_verify("MyPassword123", $dbHash)
   ↓
   Compares safely without decryption
   ↓
   If passwords match: Returns TRUE ✓
   If passwords don't match: Returns FALSE ✗

SECURITY BENEFITS
   • Original password never stored
   • Hash cannot be reversed to get password
   • Even database breaches don't expose passwords
   • Uses bcrypt algorithm (industry standard)
   • Includes automatic salt (makes it more secure)
```

---

## 🌐 HTTP Request/Response Cycle

```
┌──────────────────────────────────────────────────────────────────┐
│              HTTP REQUEST/RESPONSE CYCLE                         │
└──────────────────────────────────────────────────────────────────┘

SIGNUP FORM SUBMISSION
1. Browser sends HTTP POST request:
   POST /index.php?action=register HTTP/1.1
   Host: localhost
   Content-Type: application/x-www-form-urlencoded
   
   username=john_doe&email=john@ex.com&password=test123&...

2. Server processes request:
   ├─ index.php receives request
   ├─ Calls SignupController->register()
   ├─ Validates data
   ├─ Saves to database
   └─ Generates response

3. Server sends HTTP response:
   HTTP/1.1 302 Found (Redirect)
   Location: /index.php?action=login
   Set-Cookie: PHPSESSID=abc123def456; ...
   
4. Browser follows redirect and loads login page

LOGIN FORM SUBMISSION
1. Browser sends HTTP POST request:
   POST /index.php?action=login-submit HTTP/1.1
   Host: localhost
   Cookie: PHPSESSID=abc123def456
   
   email=john@ex.com&password=test123

2. Server processes request:
   ├─ index.php receives request
   ├─ Calls LoginController->login()
   ├─ Checks database
   ├─ Creates session
   └─ Generates response

3. Server sends HTTP response:
   HTTP/1.1 302 Found (Redirect)
   Location: /dashboard.php
   Set-Cookie: PHPSESSID=new987new; ...

4. Browser follows redirect and loads dashboard

ACCESSING DASHBOARD (AUTHENTICATED)
1. Browser sends HTTP GET request:
   GET /dashboard.php HTTP/1.1
   Host: localhost
   Cookie: PHPSESSID=new987new; ...

2. Server processes request:
   ├─ dashboard.php checks $_SESSION['user_id']
   ├─ Session is valid from login
   └─ Displays protected content

3. Server sends HTTP response:
   HTTP/1.1 200 OK
   Content-Type: text/html
   
   <html>...</html> (Dashboard page)

4. Browser displays the dashboard with user info
```

---

## 🎯 Controller Method Hierarchy

```
┌──────────────────────────────────────────────────────────────────┐
│                   CONTROLLER METHODS                             │
└──────────────────────────────────────────────────────────────────┘

SignupController
├─ __construct()
│  └─ Initializes database connection & User model
│
├─ index() [GET request]
│  ├─ Checks if user already logged in
│  ├─ If yes: Redirect to dashboard
│  └─ If no: Load signup form (view)
│
└─ register() [POST request]
   ├─ Validates form data (server-side)
   ├─ Checks for duplicate email/username
   ├─ Calls User->register()
   ├─ On success: Redirect to login
   └─ On failure: Redirect to signup with error

LoginController
├─ __construct()
│  └─ Initializes database connection & User model
│
├─ index() [GET request]
│  ├─ Checks if user already logged in
│  ├─ If yes: Redirect to dashboard
│  └─ If no: Load login form (view)
│
├─ login() [POST request]
│  ├─ Validates form data (server-side)
│  ├─ Calls User->login()
│  ├─ On success: Create session, redirect to dashboard
│  └─ On failure: Redirect to login with error
│
└─ logout() [GET request]
   ├─ Destroys session
   └─ Redirects to login

User (Model)
├─ __construct($db)
│  └─ Stores database connection
│
├─ login()
│  ├─ Queries database by email
│  ├─ Verifies password
│  └─ Returns user data
│
├─ register()
│  ├─ Hashes password
│  ├─ Inserts new user
│  └─ Returns success/failure
│
├─ emailExists()
│  ├─ Checks if email in database
│  └─ Returns true/false
│
└─ usernameExists()
   ├─ Checks if username in database
   └─ Returns true/false
```

---

## 📁 File Interaction Diagram

```
┌──────────────────────────────────────────────────────────────────┐
│              FILE INTERACTIONS & DATA FLOW                       │
└──────────────────────────────────────────────────────────────────┘

index.php (Router)
    ↓ receives request with action
    ├─ action=signup → SignupController->index()
    ├─ action=register → SignupController->register()
    ├─ action=login → LoginController->index()
    ├─ action=login-submit → LoginController->login()
    └─ action=logout → LoginController->logout()

SignupController & LoginController
    ↓ creates instance of
    └─ User.php (Model)
       ├─ login(): queries database
       ├─ register(): inserts to database
       ├─ emailExists(): checks database
       └─ usernameExists(): checks database
    
    ↓ loads
    ├─ views/signup.php (HTML form)
    └─ views/login.php (HTML form)

signup.php & login.php
    ↓ loads
    ├─ assets/css/style.css (Styling)
    ├─ assets/js/signup.js (Client validation)
    └─ assets/js/login.js (Client validation)

config/database.php (Database Connection)
    ↑ used by
    └─ All controllers & models
       ├─ User.php uses $this->conn
       └─ Connected via PDO
```

---

## ✅ Validation Layers

```
┌──────────────────────────────────────────────────────────────────┐
│              VALIDATION LAYERS (Defense in Depth)               │
└──────────────────────────────────────────────────────────────────┘

Layer 1: HTML Level (Browser)
├─ <input type="email"> enforces email format
├─ <input minlength="3"> enforces minimum length
└─ <input required> enforces required fields

Layer 2: JavaScript Validation (Client-side)
├─ signup.js validates before form submission
├─ Checks username format, email, password match
└─ Shows user-friendly error messages

Layer 3: Server-side Validation (PHP)
├─ SignupController->register() validates again
├─ Checks required fields
├─ Validates formats
└─ Prevents invalid data reaching database

Layer 4: Database Constraints
├─ PRIMARY KEY on id (unique)
├─ UNIQUE constraint on email (no duplicates)
├─ UNIQUE constraint on username (no duplicates)
└─ NOT NULL on required fields

Layer 5: Application Logic (Model)
├─ User->emailExists() prevents duplicate registration
├─ User->usernameExists() prevents duplicate usernames
├─ password_verify() ensures correct password

Result: Invalid data cannot reach database or cause issues!
```

---

## 🎯 Security Checks at Each Step

```
┌──────────────────────────────────────────────────────────────────┐
│                    SECURITY CHECKS                               │
└──────────────────────────────────────────────────────────────────┘

SIGNUP PROCESS
Step 1: Form Submission
   ├─ Check: All required fields present
   └─ Prevent: Empty form submission

Step 2: Format Validation
   ├─ Check: Email format valid
   ├─ Check: Username format valid
   ├─ Check: Password meets requirements
   └─ Prevent: Invalid data

Step 3: Duplicate Check
   ├─ Query: SELECT FROM users WHERE email = ?
   ├─ Query: SELECT FROM users WHERE username = ?
   └─ Prevent: Multiple accounts same email/username

Step 4: Password Hashing
   ├─ Hash: password_hash() creates bcrypt hash
   └─ Store: Only hash in database, not password

Step 5: Database Insert
   ├─ Use: Prepared statements (parameters)
   └─ Prevent: SQL injection attacks

Step 6: Output
   ├─ Escape: htmlspecialchars() all output
   └─ Prevent: XSS attacks

LOGIN PROCESS
Step 1: Input Validation
   ├─ Check: Email format valid
   ├─ Check: Password not empty
   └─ Prevent: Invalid input

Step 2: Database Query
   ├─ Use: Prepared statement
   ├─ Query: SELECT password WHERE email = ?
   └─ Prevent: SQL injection

Step 3: Password Verification
   ├─ Use: password_verify() function
   ├─ Compare: Input password vs database hash
   └─ Prevent: Unauthorized access

Step 4: Session Management
   ├─ Create: $_SESSION variables
   ├─ Store: user_id, username, email
   └─ Prevent: Session hijacking (server-side)

Step 5: Output
   ├─ Escape: All user data output
   └─ Prevent: XSS attacks
```

---

This visual guide should help you understand how all the pieces work together! 🚀
