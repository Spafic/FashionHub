<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../public/login.php');
    exit();
}

$products = Product::getProducts('women');

// Sorting logic
if (isset($_GET['sort']) && isset($_GET['order'])) {
    $sortBy = $_GET['sort'];
    $order = $_GET['order'];
    if (in_array($sortBy, ['price', 'rating']) && in_array($order, ['asc', 'desc'])) {
        usort($products, function ($a, $b) use ($sortBy, $order) {
            $result = $a->{"get" . ucfirst($sortBy)}() <=> $b->{"get" . ucfirst($sortBy)}();
            return $order === 'asc' ? $result : -$result;
        });
    }
}

// Search logic
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $products = array_filter($products, function ($product) use ($search) {
        return (stripos($product->getName(), $search) !== false) ||
            (stripos($product->getDescription(), $search) !== false);
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Women Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../styles/admin.css" type="text/css" />
    <link rel="stylesheet" href="../styles/home.css" type="text/css" />
    <link rel="stylesheet" href="../styles/fashion.css" type="text/css" />
    <link rel="stylesheet" href="../styles/homeFooter.css" type="text/css" />
    <link rel="stylesheet" href="../styles/nav.css" type="text/css" />
</head>

<body>
    <?php require_once('../common/adminNav.html'); ?>

    <main>
        <!-- Add this right after the <main> tag -->
        <div id="message-container" class="message-container"></div>
        <h1 id="animated-header">Admin - Women Section Management</h1>
        <div class="search-sort-container">
            <form action="" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input type="text" id="search" name="search" placeholder="Search products..."
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="sort-options">
                <a href="?sort=price&order=asc<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="sort-option">
                    <i class="fas fa-sort-amount-down-alt"></i> Price: Low to High
                </a>
                <a href="?sort=price&order=desc<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="sort-option">
                    <i class="fas fa-sort-amount-down"></i> Price: High to Low
                </a>
                <a href="?sort=rating&order=desc<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="sort-option">
                    <i class="fas fa-star"></i> Rating: High to Low
                </a>
                <a href="?sort=rating&order=asc<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="sort-option">
                    <i class="fas fa-star-half-alt"></i> Rating: Low to High
                </a>
            </div>
        </div>

        <button id="add-new-item" class="admin-button">Add New Item</button>

        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product->getImage()); ?>"
                        alt="<?php echo htmlspecialchars($product->getName()); ?>">
                    <h2><?php echo htmlspecialchars($product->getName()); ?></h2>
                    <p class="price">$<?php echo number_format($product->getPrice(), 2); ?></p>
                    <p class="rating">
                        Rating: <?php echo number_format($product->getRating(), 1); ?>
                        <span class="num-ratings">(<?php echo $product->getNumRatings(); ?> ratings)</span>
                    </p>
                    <p class="description"><?php echo htmlspecialchars($product->getDescription()); ?></p>
                    <div class="button-container">
                        <button class="edit-product" data-id="<?php echo $product->getId(); ?>">
                            <i class="fas fa-edit"></i> Edit Product
                        </button>
                        <button class="remove-product" data-id="<?php echo $product->getId(); ?>">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <div id="add-item-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Item</h2>
                <form id="add-item-form" enctype="multipart/form-data">
                    <input type="text" id="add-name" name="name" placeholder="Product Name" required>
                    <select id="add-category" name="category" required>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                        <option value="kids">Kids</option>
                    </select>
                    <input type="number" id="add-price" name="price" placeholder="Price" step="0.01" required>
                    <input type="file" id="add-image" name="image" accept="image/*" required>
                    <textarea id="add-description" name="description" placeholder="Description" required></textarea>
                    <button type="submit" class="admin-button">Add Item</button>
                </form>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div id="edit-product-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Product</h2>
                <form id="edit-product-form" enctype="multipart/form-data">
                    <input type="hidden" id="edit-id" name="id">
                    <input type="text" id="edit-name" name="name" placeholder="Product Name" required>
                    <select id="edit-category" name="category" required>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                        <option value="kids">Kids</option>
                    </select>
                    <input type="number" id="edit-price" name="price" placeholder="Price" step="0.01" required>
                    <input type="file" id="edit-image" name="image" accept="image/*">
                    <p><strong style="font-style:italic">Current Image:</strong> <span id="current-image-name"></span>
                    </p>
                    <textarea id="edit-description" name="description" placeholder="Description" required></textarea>
                    <button type="submit" class="button-save edit-product">Save Changes</button>
                </form>
            </div>
        </div>


        <!-- Remove Product Modal -->
        <div id="remove-product-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Remove Product</h2>
                <p>Are you sure you want to remove this product?</p>
                <button id="confirm-remove">Yes, Remove</button>
                <button id="cancel-remove">Cancel</button>
            </div>
        </div>

        <script src="../js/admin.js"></script>
        <script src="../js/hamburgerMenu.js"></script>
    </main>

    <?php include '../common/insidefooter.html'; ?>
</body>

</html>