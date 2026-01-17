-- Database Setup SQL
-- Run this in phpMyAdmin or MySQL command line
-- This creates the database and users table for the login system

-- Create database
CREATE DATABASE IF NOT EXISTS login_system;

-- Use the database
USE login_system;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create indexes for faster queries
CREATE INDEX idx_email ON users(email);
CREATE INDEX idx_username ON users(username);

-- Insert sample user (password: password123)
INSERT INTO users (username, email, password) VALUES
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Display success message
SELECT 'Database and table created successfully!' AS message;
