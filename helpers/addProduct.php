<?php
require_once '../helpers/Product.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $uploadDir = '../data/imgs/' . $_POST['category'] . 'Products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $data = [
                'name' => $_POST['name'],
                'category' => $_POST['category'],
                'price' => floatval($_POST['price']),
                'image' => $uploadFile,
                'description' => $_POST['description']
            ];

            error_log("Attempting to add product with data: " . json_encode($data));

            $result = Product::addProduct($data);
            if ($result) {
                echo json_encode(['success' => true, 'product' => $result->toArray()]);
            } else {
                throw new Exception('Failed to add product');
            }
        } else {
            throw new Exception('Failed to upload image. Upload error code: ' . $_FILES['image']['error']);
        }
    } catch (Exception $e) {
        error_log('Error in addProduct.php: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
