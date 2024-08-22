<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../public/login.php');
    exit();
}
if ($_SESSION['username'] == 'admin') {
    header('Location: ../public/adminMenSection.php');
    exit();
}

$products = Product::getProducts('kids');

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
            (stripos($product->getCategory(), $search) !== false);
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kids Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/home.css" type="text/css" />
    <link rel="stylesheet" href="../styles/homeFooter.css" type="text/css" />
    <link rel="stylesheet" href="../styles/fashion.css" type="text/css" />
    <link rel="stylesheet" href="../styles/nav.css" type="text/css" />
</head>

<body>
    <?php require_once ('../common/fashionnav.html'); ?>

    <main>
        <h1>Kids Section</h1>

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


<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product->getImage()); ?>"
                     alt="<?php echo htmlspecialchars($product->getName()); ?>">
            </div>
            <div class="product-info">
                <h2><?php echo htmlspecialchars($product->getName()); ?></h2>
                <p class="price">$<?php echo number_format($product->getPrice(), 2); ?></p>
                <p class="rating">
                    Rating: <?php echo number_format($product->getRating(), 1); ?>
                    <span class="num-ratings">(<?php echo $product->getNumRatings(); ?> ratings)</span>
                </p>
                <p class="description"><?php echo htmlspecialchars($product->getDescription()); ?></p>
                <div class="button-container">
                    <button class="add-to-cart" data-id="<?php echo $product->getId(); ?>">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <button class="rate-product" data-id="<?php echo $product->getId(); ?>">
                        <i class="fas fa-star"></i> Rate
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        <div id="quantity-modal" class="modal">
            <div class="modal-content">
                <h2>Select Quantity</h2>
                <input type="number" id="quantity-input" min="1" value="1">
                <div class="addCart-buttons-container">
                    <button class="btn btn-confirm" id="confirm-add-to-cart">Add to Cart</button>
                    <button class="btn btn-cancel" id="cancel-add-to-cart">Cancel</button>
                </div>
            </div>
        </div>
                
        <script src="../js/cart.js"></script>
    </main>

    <div class="modal" id="rating-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Rate this product</h2>
            <div class="star-rating" id="star-rating">
                <span class="star" data-rating="1">&#9733;</span>
                <span class="star" data-rating="2">&#9733;</span>
                <span class="star" data-rating="3">&#9733;</span>
                <span class="star" data-rating="4">&#9733;</span>
                <span class="star" data-rating="5">&#9733;</span>
            </div>
            <button id="submit-rating">Submit Rating</button>
        </div>
    </div>

    
    <script src="../js/fashion.js"></script>
</body>

<?php include '../common/insidefooter.html'; ?>
</html>

