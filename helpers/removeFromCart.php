<?php
require_once '../helpers/session_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    
    // Remove the item from the cart in session
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        
        // Update the cart in the JSON file
        $cartFile = '../data/cart.json';
        if (file_exists($cartFile)) {
            $cartData = json_decode(file_get_contents($cartFile), true);
            
            if (isset($cartData['cart'])) {
                // Filter out the removed item
                $cartData['cart'] = array_filter($cartData['cart'], function($item) use ($productId) {
                    return $item['id'] != $productId;
                });
                
                // Save the updated cart data
                if (file_put_contents($cartFile, json_encode(['cart' => array_values($cartData['cart'])], JSON_PRETTY_PRINT))) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update cart file']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cart file not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
