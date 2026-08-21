<?php
session_start();

$product_id = (int) ($_POST['product_id'] ?? 0);
$quantity = (int) ($_POST['quantity'] ?? 1);

if ($product_id > 0 && $quantity > 0) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // If it's already in the cart, add to existing quantity
    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
}

header('Location: cart.php');
exit;