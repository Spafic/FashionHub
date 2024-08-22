<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'];
    $rating = $data['rating'];

    $products = Product::getProducts();
    foreach ($products as &$product) {
        if ($product->getId() == $productId) {
            $currentRating = $product->getRating();
            $numRatings = $product->getNumRatings();
            $newRating = (($currentRating * $numRatings) + $rating) / ($numRatings + 1);
            $product->setRating($newRating);
            $product->setNumRatings($numRatings + 1);
            break;
        }
    }

    // Save updated products to JSON file
    file_put_contents('../data/products/products.json', json_encode($products, JSON_PRETTY_PRINT));

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}