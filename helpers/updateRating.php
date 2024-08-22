<?php
header('Content-Type: application/json');

$response = ['success' => false];

try {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['productId'], $input['rating'])) {
        throw new Exception('Invalid input');
    }

    $productId = $input['productId'];
    $rating = $input['rating'];

    // Validate the input
    if (!is_numeric($productId) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
        throw new Exception('Invalid data');
    }

    // Load products from file or database (Example for file)
    $filePath = '../data/products/products.json';
    $products = json_decode(file_get_contents($filePath), true);
    
    foreach ($products as &$product) {
        if ($product['id'] == $productId) {
            // Update rating logic here
            $totalRating = $product['rating'] * $product['numRatings'];
            $product['numRatings']++;
            $product['rating'] = ($totalRating + $rating) / $product['numRatings'];
            break;
        }
    }

    // Save back to file
    if (file_put_contents($filePath, json_encode($products, JSON_PRETTY_PRINT))) {
        $response['success'] = true;
    } else {
        throw new Exception('Failed to save data');
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
