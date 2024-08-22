document.addEventListener('DOMContentLoaded', function () {
    const decreaseButtons = document.querySelectorAll('.quantity-decrease');
    const increaseButtons = document.querySelectorAll('.quantity-increase');
    const removeButtons = document.querySelectorAll('.remove-item');
    const orderForm = document.getElementById('order-form');
    const orderMessage = document.getElementById('order-message');

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            updateQuantity(productId, -1); // Decrease quantity by 1
        });
    });

    increaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            updateQuantity(productId, 1); // Increase quantity by 1
        });
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            removeItem(productId);
        });
    });

    orderForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(orderForm);
        const orderData = Object.fromEntries(formData.entries());

        // Add cart items to the order data
        orderData.items = Array.from(document.querySelectorAll('.cart-item')).map(item => ({
            id: item.getAttribute('data-id'),
            name: item.querySelector('h2').textContent,
            price: parseFloat(item.querySelector('.cart-item-details p:first-of-type').textContent.replace('Price: $', '')),
            quantity: parseInt(item.querySelector('.item-quantity').textContent)
        }));

        // Add total price to the order data
        orderData.totalPrice = parseFloat(document.getElementById('total-price').textContent);

        // Log the order data for debugging
        console.log('Order Data:', orderData);

        fetch('../helpers/confirmOrder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear cart UI
                    document.querySelector('.cart-items-container').innerHTML = '<p>Your cart is empty.</p>';
                    document.getElementById('total-price').textContent = '0.00 $';
                    document.getElementById('order-form').reset();

                    // Display success message
                    orderMessage.innerHTML = 'Order confirmed successfully!<br>Your order will be shipped within 3 days.';
                    orderMessage.className = 'success-message'; // Apply CSS class for styling and animation
                } else {
                    orderMessage.textContent = 'Failed to confirm order. Please try again.';
                    orderMessage.className = 'error-message'; // Apply CSS class for styling and animation
                }
            })
            .catch(error => {
                console.error('Error:', error);
                orderMessage.textContent = 'An error occurred. Please try again.';
                orderMessage.className = 'error-message'; // Apply CSS class for styling and animation
            });
    });

    function updateQuantity(productId, change) {
        fetch('../helpers/updateCart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&change=${change}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the quantity displayed on the page
                    const quantitySpan = document.querySelector(`.cart-item[data-id="${productId}"] .item-quantity`);
                    const currentQuantity = parseInt(quantitySpan.textContent);
                    const newQuantity = currentQuantity + change;

                    if (newQuantity > 0) {
                        quantitySpan.textContent = newQuantity;
                    } else {
                        location.reload(); // Reload to reflect removal
                    }

                    // Update the total price
                    const price = parseFloat(document.querySelector(`.cart-item[data-id="${productId}"] .cart-item-details p:first-of-type`).textContent.replace('Price: $', ''));
                    updateTotalPrice(change * price);
                } else {
                    alert('Failed to update quantity. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    }

    function removeItem(productId) {
        fetch('../helpers/removeFromCart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the item from the page
                    const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`);
                    if (cartItem) {
                        const quantity = parseInt(cartItem.querySelector('.item-quantity').textContent);
                        const price = parseFloat(cartItem.querySelector('.cart-item-details p:first-of-type').textContent.replace('Price: $', ''));
                        updateTotalPrice(-quantity * price);
                        cartItem.remove();
                    }
                } else {
                    alert('Failed to remove item from cart. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    }

    function updateTotalPrice(amount) {
        const totalPriceElement = document.getElementById('total-price');
        const currentTotal = parseFloat(totalPriceElement.textContent);
        const newTotal = currentTotal + amount;
        totalPriceElement.textContent = newTotal.toFixed(2) + ' $';
    }
});
