<?php
// config/db.php

$host = '127.0.0.1';
$dbname = 'ecommerce_proj';
$username = 'root';
$password = ''; // Laragon's default MySQL root user has no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Make PDO throw exceptions on errors instead of failing silently
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}