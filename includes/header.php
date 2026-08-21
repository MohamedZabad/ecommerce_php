<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Store</title>
    <link rel="stylesheet" href="/ecommerce-proj/style.css">
</head>
<body>
<header>
    <a href="/ecommerce-proj/index.php" class="logo">My Store</a>
    <nav>
        <a href="/ecommerce-proj/index.php">Shop</a>
        <a href="/ecommerce-proj/cart.php">
            Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)
        </a>
    </nav>
</header>
<main>