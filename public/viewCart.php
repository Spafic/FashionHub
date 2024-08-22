<?php
require_once '../helpers/session_config.php';
require_once '../helpers/Product.php';

$username = $_SESSION['username'] ?? header('Location: ../public/login.php');
$userEmail = $_SESSION['email'] ?? header('Location: ../public/login.php');

$cartItems = [];
$totalPrice = 0;

$jsonCartData = file_get_contents('../data/cart.json');
$cartData = json_decode($jsonCartData, true);

if (isset($cartData['cart']) && !empty($cartData['cart'])) {
    foreach ($cartData['cart'] as $item) {
        $product = Product::getProductById($item['id']);
        if ($product) {
            $cartItems[] = [
                'product' => $product,
                'quantity' => $item['quantity']
            ];
            $totalPrice += $product->getPrice() * $item['quantity'];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/fashion.css">
    <link rel="stylesheet" href="../styles/homeFooter.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/nav.css">
</head>

<body>
    <?php require_once ('../common/fashionnav.html'); ?>

    <main>
        <h1 class="cart-header">Your Cart</h1>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="cart-items-container">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item" data-id="<?php echo $item['product']->getId(); ?>">
                        <img src="<?php echo htmlspecialchars($item['product']->getImage()); ?>"
                            alt="<?php echo htmlspecialchars($item['product']->getName()); ?>">
                        <div class="cart-item-details">
                            <h2><?php echo htmlspecialchars($item['product']->getName()); ?></h2>
                            <p>Price: $<?php echo number_format($item['product']->getPrice(), 2); ?></p>
                            <p>
                                Quantity:
                            <div class="quantity-container">
                                <button class="quantity-decrease" data-id="<?php echo $item['product']->getId(); ?>">-</button>
                                <span class="item-quantity"><?php echo $item['quantity']; ?></span>
                                <button class="quantity-increase" data-id="<?php echo $item['product']->getId(); ?>">+</button>
                            </div>
                            </p>
                            <button class="remove-item" data-id="<?php echo $item['product']->getId(); ?>">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Total Price -->
            <div class="total-price-container">
                <h2 class="total-price">Total Price: <span id="total-price"><?php echo number_format($totalPrice, 2); ?> $</span></h2>
            </div>
        <?php endif; ?>

        <div id="confirm-order-section">
            <h2>Order Information</h2>
            <form id="order-form">
                <input type="hidden" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
                <button type="submit" id="confirm-order-btn">Confirm Order</button>
            </form>
            <p id="order-message"></p> <!-- Placeholder for messages -->
        </div>
    </main>

    <?php include '../common/insidefooter.html'; ?>

    <script src="../js/viewCart.js"></script>
    <script src="../js/hamburgerMenu.js"></script>
</body>

</html>

