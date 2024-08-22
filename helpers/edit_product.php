<?php
require_once '../helpers/Product.php';

require_once '../helpers/session_config.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $product = Product::getProductById($id);

    if ($product) {
        $data = [
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];

        // Handle image update if a new image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../data/imgs/products/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $data['image'] = $uploadFile;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload new image']);
                exit();
            }
        }

        try {
            $product->updateDetails($data);
            $product->saveToFile('../data/products/products.json');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error updating product: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>