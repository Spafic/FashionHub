<?php
require_once 'session_config.php';
require_once 'Product.php';

if ($_SESSION['username'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    // Update existing product
    $product = Product::getProductById($data['id']);
    if ($product) {
        $product->updateDetails($data);
        $product->saveToFile('../data/products/products.json');
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} else {
    // Add new product
    $newProduct = new Product($data);
    $newProduct->saveToFile('../data/products/products.json');
    echo json_encode(['success' => true]);
}