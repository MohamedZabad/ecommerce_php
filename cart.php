<?php
require 'config/db.php';
include 'includes/header.php';

$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $subtotal = $qty * $p['price'];
        $total += $subtotal;
        $cartItems[] = ['product' => $p, 'qty' => $qty, 'subtotal' => $subtotal];
    }
}
?>

<h1>Your Cart</h1>

<?php if (empty($cartItems)): ?>
    <p>Your cart is empty. <a href="index.php">Browse products</a></p>
<?php else: ?>
    <table>
        <tr><th>Product</th><th>Qty</th><th>Subtotal</th><th></th></tr>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product']['name']) ?></td>
                <td><?= $item['qty'] ?></td>
                <td>$<?= number_format($item['subtotal'], 2) ?></td>
                <td><a href="remove_from_cart.php?id=<?= $item['product']['id'] ?>">Remove</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h3>Total: $<?= number_format($total, 2) ?></h3>
    <a class="btn" href="checkout.php">Proceed to Checkout</a>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>