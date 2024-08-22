<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
    
    // Prepare cart data for JSON response and file
    $cartItems = [];
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $product = Product::getProductById($pid);
        if ($product) {
            $cartItems[] = [
                'id' => $pid,
                'name' => $product->getName(),
                'image' => $product->getImage(),
                'quantity' => $qty,
                'price' => $product->getPrice()
            ];
        }
    }
    
    // Save cart data to JSON file
    $jsonData = json_encode(['cart' => $cartItems]);
    file_put_contents('../data/cart.json', $jsonData);
    
    echo json_encode(['success' => true, 'cartItems' => $cartItems]);
} else {
    echo json_encode(['success' => false]);
}