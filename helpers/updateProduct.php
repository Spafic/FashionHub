<?php
require_once '../helpers/Product.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $uploadDir = '../data/imgs/' . $category . 'Products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $data = [
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'price' => floatval($_POST['price']),
            'description' => $_POST['description']
        ];

        if (!empty($_FILES['image']['name'])) {
            $imageName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $relativeImagePath = '/data/imgs/' . $category . 'Products/' . $imageName;
                $data['image'] = $relativeImagePath;
            } else {
                throw new Exception('Failed to upload image. Upload error code: ' . $_FILES['image']['error']);
            }
        } else {
            // If no new image is uploaded, keep the existing image path
            $product = Product::getProductById($id);
            $data['image'] = $product->getImage();
        }

        $product = Product::getProductById($id);
        if ($product) {
            $product->updateDetails($data);
            $product->saveToFile('../data/products/products.json');
            echo json_encode(['success' => true, 'message' => 'Product updated successfully!']);
        } else {
            throw new Exception('Product not found');
        }
    } catch (Exception $e) {
        error_log('Error in updateProduct.php: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}