<?php
require_once '../helpers/Product.php';

if (isset($_GET['id'])) {
    $product = Product::getProductById($_GET['id']);
    if ($product) {
        echo json_encode($product->toArray());
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'No product ID provided']);
}