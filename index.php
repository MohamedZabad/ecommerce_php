<?php
require 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<h1>Shop Products</h1>
<div class="product-grid">
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($p['image'] ?: 'placeholder.jpg') ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p class="price">$<?= number_format($p['price'], 2) ?></p>
            <a class="btn" href="product.php?id=<?= $p['id'] ?>">View</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>