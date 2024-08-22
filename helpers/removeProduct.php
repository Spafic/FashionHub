<?php
    require_once '../helpers/Product.php';
    
    header('Content-Type: application/json');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Validate ID format (ensure it's a valid integer or string)
        if (is_numeric($id) && $id > 0) {
            $result = Product::removeProduct($id);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
    
