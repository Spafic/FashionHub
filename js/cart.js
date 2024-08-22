document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const quantityModal = document.getElementById('quantity-modal');
    const quantityInput = document.getElementById('quantity-input');
    const confirmAddToCartBtn = document.getElementById('confirm-add-to-cart');
    const cancelAddToCartBtn = document.getElementById('cancel-add-to-cart');
    let currentProductId = null;

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentProductId = this.getAttribute('data-id');
            quantityModal.style.display = 'block';
            quantityInput.value = 1;
        });
    });

    confirmAddToCartBtn.addEventListener('click', function() {
        const quantity = parseInt(quantityInput.value);
        if (quantity > 0) {
            addToCart(currentProductId, quantity);
            quantityModal.style.display = 'none';
        }
    });

    cancelAddToCartBtn.addEventListener('click', function() {
        quantityModal.style.display = 'none';
    });

    // In cart.js, modify the addToCart function:

function addToCart(productId, quantity) {
    fetch('../helpers/addToCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMiniCart(data.cartItems);
        } else {
            alert('Failed to add product to cart. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

function showMiniCart(cartItems) {
    const miniCart = document.createElement('div');
    miniCart.className = 'mini-cart';
    miniCart.innerHTML = `
        <h3>Cart Preview</h3>
        ${cartItems.map(item => `
            <div class="mini-cart-item">
                <img src="${item.image}" alt="${item.name}" width="50">
                <span>${item.name} - Quantity: ${item.quantity}</span>
            </div>
        `).join('')}
        <button id="view-cart">View Cart</button>
        <button id="close-mini-cart">Close</button>
    `;
    document.body.appendChild(miniCart);

    document.getElementById('view-cart').addEventListener('click', () => {
        window.location.href = 'viewCart.php';
    });

    document.getElementById('close-mini-cart').addEventListener('click', () => {
        document.body.removeChild(miniCart);
    });
}
});