<?php
require 'config/db.php';
include 'includes/header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_active = 1");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<p>Product not found.</p>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="product-detail">
    <img src="<?= htmlspecialchars($product['image'] ?: 'placeholder.jpg') ?>" style="max-width:300px;">
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <p class="price">$<?= number_format($product['price'], 2) ?></p>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    <p>In stock: <?= (int)$product['stock'] ?></p>

    <form method="POST" action="add_to_cart.php">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label>Quantity: <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>"></label>
        <button type="submit">Add to Cart</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>