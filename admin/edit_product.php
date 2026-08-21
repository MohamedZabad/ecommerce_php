<?php
require 'includes/auth_check.php';
require '../config/db.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $imagePath = $product['image']; // keep existing unless a new one is uploaded

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $newName = uniqid('prod_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $newName);
            $imagePath = 'uploads/' . $newName;
        }
    }

    if ($name && $price > 0) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, image=?, stock=? WHERE id=?");
        $stmt->execute([$name, $description, $price, $imagePath, $stock, $id]);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Name and price are required.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<main style="max-width:500px;">
    <h1>Edit Product</h1>
    <?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>

    <?php if ($product['image']): ?>
        <img src="../<?= htmlspecialchars($product['image']) ?>" style="width:100px;">
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <label>Name <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required></label>
        <label>Description <textarea name="description" rows="4"><?= htmlspecialchars($product['description']) ?></textarea></label>
        <label>Price <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required></label>
        <label>Stock <input type="number" name="stock" value="<?= $product['stock'] ?>"></label>
        <label>Replace Image <input type="file" name="image" accept="image/*"></label>
        <button type="submit">Save Changes</button>
    </form>
    <p><a href="dashboard.php">&larr; Back to Dashboard</a></p>
</main>
</body>
</html>