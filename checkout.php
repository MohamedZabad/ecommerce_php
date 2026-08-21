<?php
require 'config/db.php';
include 'includes/header.php';

if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    include 'includes/footer.php';
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name && $address) {
        // Calculate total + build order_items
        $ids = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;
        $items = [];
        foreach ($products as $p) {
            $qty = $_SESSION['cart'][$p['id']];
            $total += $qty * $p['price'];
            $items[] = ['product_id' => $p['id'], 'quantity' => $qty, 'price' => $p['price']];
        }

        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, address, total) VALUES (?, ?, ?)");
        $stmt->execute([$name, $address, $total]);
        $orderId = $pdo->lastInsertId();

        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
        }

        unset($_SESSION['cart']); // clear cart
        $message = "Order #$orderId placed successfully!";
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<h1>Checkout</h1>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST">
        <label>Name<input type="text" name="name" required></label>
        <label>Address<textarea name="address" required></textarea></label>
        <button type="submit">Place Order</button>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>