<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "1234";
$db = "onlineshop";

try {
    // Changed port from 3307 to 3306 (Standard XAMPP port)
    $con = new PDO("mysql:host=$servername;port=3306;dbname=$db;charset=utf8", $username, $password);
    
    // Enable exceptions for error handling
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Log error and stop execution
    die("Connection failed: " . $e->getMessage());
}

// CSRF Token Generation (Only start session if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>