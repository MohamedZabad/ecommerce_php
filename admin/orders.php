<?php
require 'includes/auth_check.php';
require '../config/db.php';

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <span class="logo">Admin Panel</span>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<main>
    <h1>Orders</h1>
    <table>
        <tr><th>ID</th><th>Customer</th><th>Address</th><th>Total</th><th>Date</th></tr>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td><?= htmlspecialchars($o['address']) ?></td>
                <td>$<?= number_format($o['total'], 2) ?></td>
                <td><?= $o['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="dashboard.php">&larr; Back to Dashboard</a></p>
</main>
</body>
</html>