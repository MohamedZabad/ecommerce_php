<?php
require 'config/db.php';

$json = file_get_contents('https://fakestoreapi.com/products');
$products = json_decode($json, true);

$stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");

foreach ($products as $p) {
    $stmt->execute([
        $p['title'],
        $p['description'],
        $p['price'],
        $p['image'], // this will be a full URL, not a local filename
        rand(5, 50)  // random stock number since the API doesn't provide one
    ]);
}

echo "Seeded " . count($products) . " products!";