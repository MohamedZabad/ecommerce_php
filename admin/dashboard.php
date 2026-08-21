<?php
require 'includes/auth_check.php';
require '../config/db.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();

$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$revenue = $pdo->query("SELECT COALESCE(SUM(total), 0) FROM orders")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <span class="logo">Admin Panel</span>
    <nav>
        <span>Hi, <?= htmlspecialchars($_SESSION['admin_username']) ?></span>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
<main>
    <h1>Dashboard</h1>
    <?php if (isset($_SESSION['flash_error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['flash_error']) ?></p>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>
    <p>Total orders: <strong><?= $orderCount ?></strong> &nbsp; | &nbsp; Total revenue: <strong>$<?= number_format($revenue, 2) ?></strong></p>

    <a class="btn" href="add_product.php">+ Add New Product</a>

    <table>
        <tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
        <?php foreach ($products as $p): ?>
            <tr>
    <td><img src="<?= htmlspecialchars($p['image'] ?: '../placeholder.jpg') ?>" style="width:50px;height:50px;object-fit:cover;"></td>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td>$<?= number_format($p['price'], 2) ?></td>
    <td><?= (int)$p['stock'] ?></td>
    <td><?= $p['is_active'] ? '<span style="color:green;">Active</span>' : '<span style="color:#999;">Hidden</span>' ?></td>
    <td>
        <a href="edit_product.php?id=<?= $p['id'] ?>">Edit</a> |
        <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('<?= $p['is_active'] ? 'Hide' : 'Reactivate' ?> this product?')">
            <?= $p['is_active'] ? 'Hide' : 'Reactivate' ?>
        </a>
    </td>
</tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>