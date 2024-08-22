document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const rateProductButtons = document.querySelectorAll('.rate-product');
    const editProductButtons = document.querySelectorAll('.edit-product');
    const removeProductButtons = document.querySelectorAll('.remove-product');
    const ratingModal = document.getElementById('rating-modal');
    const cartModal = document.getElementById('quantity-modal');
    const removeModal = document.getElementById('remove-modal');
    const closeButtons = document.querySelectorAll('.close');
    const stars = document.querySelectorAll('.star');
    const submitRatingButton = document.getElementById('submit-rating');
    const confirmAddToCartButton = document.getElementById('confirm-add-to-cart');
    const confirmRemoveButton = document.getElementById('confirm-remove');
    const cancelRemoveButton = document.getElementById('cancel-remove');
    const quantityInput = document.getElementById('quantity-input');

    let currentProductId = null;

    // Handle Add to Cart Button Click
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            cartModal.style.display = 'block';
            quantityInput.value = '1';
        });
    });

    // Handle Rate Product Button Click
    rateProductButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            ratingModal.style.display = 'block';
        });
    });

    // Handle Edit Product Button Click
    editProductButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            // Redirect to edit product page or open an edit form
            window.location.href = `editProduct.php?id=${currentProductId}`;
        });
    });

    // Handle Remove Product Button Click
    removeProductButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            removeModal.style.display = 'block';
        });
    });

    // Handle Close Button Click
    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            ratingModal.style.display = 'none';
            cartModal.style.display = 'none';
            removeModal.style.display = 'none';
        });
    });

    // Handle Click Outside Modal
    window.addEventListener('click', function (event) {
        if (event.target === ratingModal || event.target === cartModal || event.target === removeModal) {
            ratingModal.style.display = 'none';
            cartModal.style.display = 'none';
            removeModal.style.display = 'none';
        }
    });

    // Open Rating Modal
    document.querySelectorAll('.rate-product').forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            ratingModal.style.display = 'block';
            resetRating(); // Reset rating each time
        });
    });

    // Close Modal
    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            ratingModal.style.display = 'none';
        });
    });

    // Click Outside Modal
    window.addEventListener('click', function (event) {
        if (event.target === ratingModal) {
            ratingModal.style.display = 'none';
        }
    });

    // Star Rating Hover
    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const rating = parseInt(this.getAttribute('data-rating'));
            highlightStars(rating);
        });

        star.addEventListener('mouseout', function () {
            const rating = parseInt(document.querySelector('.star.active')?.getAttribute('data-rating')) || 0;
            highlightStars(rating);
        });

        star.addEventListener('click', function () {
            const rating = parseInt(this.getAttribute('data-rating'));
            setRating(rating);
        });
    });

    // Set Rating
    function setRating(rating) {
        currentRating = rating;
        stars.forEach(star => {
            star.classList.toggle('active', parseInt(star.getAttribute('data-rating')) <= rating);
        });
    }

    // Highlight Stars
    function highlightStars(rating) {
        stars.forEach(star => {
            star.classList.toggle('hover', parseInt(star.getAttribute('data-rating')) <= rating);
        });
    }

    // Reset Rating
    function resetRating() {
        currentRating = 0;
        stars.forEach(star => {
            star.classList.remove('active', 'hover');
        });
    }

    // Submit Rating
    submitRatingButton.addEventListener('click', function () {
        if (currentRating > 0) {
            submitRating(currentProductId, currentRating);
        } else {
            displayMessage('Please select a rating before submitting.');
        }
    });

    // Submit Rating Function
    function submitRating(productId, rating) {
        fetch('../helpers/updateRating.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId, rating }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessage('Rating submitted successfully!');
                ratingModal.style.display = 'none';
                location.reload(); // Reload the page to update the ratings
            } else {
                displayMessage('Failed to submit rating. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            displayMessage('An error occurred. Please try again.');
        });
    }

    // Display Message Function
    function displayMessage(message) {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message-container');
        messageContainer.textContent = message;
        document.body.appendChild(messageContainer);

        setTimeout(() => {
            messageContainer.classList.add('fade-out');
            messageContainer.addEventListener('transitionend', () => {
                messageContainer.remove();
            });
        }, 3000);
    }
    
    // Handle Confirm Add to Cart Button Click
    confirmAddToCartButton.addEventListener('click', function () {
        const quantity = parseInt(quantityInput.value);
        if (quantity && quantity > 0) {
            addToCart(currentProductId, quantity);
            cartModal.style.display = 'none';
        } else {
            displayMessage('Please enter a valid quantity.');
        }
    });

    // Handle Confirm Remove Button Click
    confirmRemoveButton.addEventListener('click', function () {
        removeProduct(currentProductId);
        removeModal.style.display = 'none';
    });

    // Handle Cancel Remove Button Click
    cancelRemoveButton.addEventListener('click', function () {
        removeModal.style.display = 'none';
    });

    // Function to Submit Rating
    function submitRating(productId, rating) {
        fetch('../helpers/updateRating.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId, rating }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMessage('Rating submitted successfully!');
                    ratingModal.style.display = 'none';
                    location.reload(); // Reload the page to update the ratings
                } else {
                    displayMessage('Failed to submit rating. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayMessage('An error occurred. Please try again.');
            });
    }

    // Function to Add to Cart
    function addToCart(productId, quantity) {
        fetch('../helpers/addToCart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId, quantity }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMessage('Product added to cart!');
                    updateCartCount(); // Update cart item count
                } else {
                    displayMessage('Failed to add product to cart. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayMessage('An error occurred. Please try again.');
            });
    }

    // Function to Remove Product
    function removeProduct(productId) {
        fetch('../helpers/removeProduct.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMessage('Product removed successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    displayMessage('Failed to remove product. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayMessage('An error occurred. Please try again.');
            });
    }

    // Function to Update Cart Count
    function updateCartCount() {
        fetch('../helpers/getCartCount.php')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                }
            });
    }

    // Function to Display Message
    function displayMessage(message) {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message-container');
        messageContainer.textContent = message;
        document.body.appendChild(messageContainer);

        setTimeout(() => {
            messageContainer.classList.add('fade-out');
            messageContainer.addEventListener('transitionend', () => {
                messageContainer.remove();
            });
        }, 3000);
    }




    /* for hamburger menu */
    // Add this script at the end of the body

});
