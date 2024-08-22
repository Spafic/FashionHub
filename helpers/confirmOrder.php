<?php
require_once '../helpers/session_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderData = json_decode(file_get_contents('php://input'), true);

    // Log the received order data
    error_log("Received order data: " . print_r($orderData, true));

    // Add timestamp (Egypt time UTC+2)
    date_default_timezone_set('Africa/Cairo');
    $orderData['timestamp'] = date('Y-m-d h:i:s A');

    // Check for username and email
    if (empty($orderData['username'])) {
        echo json_encode(['success' => false, 'message' => 'Missing username']);
        exit;
    }

    if (empty($orderData['email'])) {
        echo json_encode(['success' => false, 'message' => 'Missing email']);
        exit;
    }

    // Load existing orders
    $ordersFile = '../data/orders.json';
    $orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];

    // Initialize orders array for the user if not present
    if (!isset($orders[$orderData['username']])) {
        $orders[$orderData['username']] = [];
    }

    // Add new order to the user's orders
    $orders[$orderData['username']][] = $orderData;

    // Save updated orders
    if (file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT))) {
        // Clear the cart after successful order
        $_SESSION['cart'] = [];
        file_put_contents('../data/cart.json', json_encode(['cart' => []]));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save order']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
