<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .welcome-card h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 32px;
        }

        .welcome-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .info-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .info-card p {
            color: #666;
        }
    </style>
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    ?>

    <div class="navbar">
        <h1>Dashboard</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="index.php?action=logout" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>Welcome to Your Dashboard!</h2>
            <p>You have successfully logged in to the system.</p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>MVC Architecture</h3>
                <p>This project follows the Model-View-Controller pattern for clean separation of concerns.</p>
            </div>

            <div class="info-card">
                <h3>Technologies Used</h3>
                <p>HTML5, CSS3, JavaScript, PHP, and MySQL working together seamlessly.</p>
            </div>

            <div class="info-card">
                <h3>Security Features</h3>
                <p>Password hashing, SQL injection protection, and session management included.</p>
            </div>
        </div>
    </div>
</body>
</html>
