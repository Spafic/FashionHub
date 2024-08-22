<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['change'])) {
    $productId = $_POST['product_id'];
    $change = intval($_POST['change']);
    
    // Ensure the cart session is initialized
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Update the quantity in the session
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $change;
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
        }
    } else {
        if ($change > 0) {
            $_SESSION['cart'][$productId] = $change;
        }
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
    $jsonData = json_encode(['cart' => $cartItems], JSON_PRETTY_PRINT);
    file_put_contents('../data/cart.json', $jsonData);
    
    echo json_encode(['success' => true, 'cartItems' => $cartItems]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
