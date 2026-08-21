<?php
require 'includes/auth_check.php';
require '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    // Toggle is_active instead of deleting
    $stmt = $pdo->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit;