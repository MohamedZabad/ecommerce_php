<?php
require 'includes/auth_check.php';
require '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $imagePath = '';

    if ($name && $price > 0) {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $newName = uniqid('prod_') . '.' . $ext;
                $destination = '../uploads/' . $newName;
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                $imagePath = 'uploads/' . $newName;
            } else {
                $error = 'Invalid image file type.';
            }
        }

        if (!$error) {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $imagePath, $stock]);
            header('Location: dashboard.php');
            exit;
        }
    } else {
        $error = 'Name and price are required.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<main style="max-width:500px;">
    <h1>Add Product</h1>
    <?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Name <input type="text" name="name" required></label>
        <label>Description <textarea name="description" rows="4"></textarea></label>
        <label>Price <input type="number" step="0.01" name="price" required></label>
        <label>Stock <input type="number" name="stock" value="0"></label>
        <label>Image <input type="file" name="image" accept="image/*"></label>
        <button type="submit">Add Product</button>
    </form>
    <p><a href="dashboard.php">&larr; Back to Dashboard</a></p>
</main>
</body>
</html>