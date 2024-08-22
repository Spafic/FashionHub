document.addEventListener('DOMContentLoaded', function () {
    const addNewItemBtn = document.getElementById('add-new-item');
    const addItemModal = document.getElementById('add-item-modal');
    const editProductModal = document.getElementById('edit-product-modal');
    const removeProductModal = document.getElementById('remove-product-modal');
    const editButtons = document.querySelectorAll('.edit-product');
    const removeButtons = document.querySelectorAll('.remove-product');
    const closeButtons = document.querySelectorAll('.close');

    let currentProductId = null;

    // Open Add New Item modal
    addNewItemBtn.addEventListener('click', function () {
        addItemModal.style.display = 'block';
    });
    // Handle Edit Product buttons
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            fetchProductDetails(currentProductId);
            editProductModal.style.display = 'block';
            document.getElementById('edit-name').focus(); // Add focus to the edit name input
        });
    });

    // Handle Remove Product buttons
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            currentProductId = this.getAttribute('data-id');
            removeProductModal.style.display = 'block';
        });
    });

    // Close modals
    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            this.closest('.modal').style.display = 'none';
        });
    });

    // Handle form submissions
    document.getElementById('add-item-form').addEventListener('submit', function (e) {
        e.preventDefault();
        addNewProduct();
    });

    document.getElementById('edit-product-form').addEventListener('submit', function (e) {
        e.preventDefault();
        updateProduct();
    });

    document.getElementById('confirm-remove').addEventListener('click', function () {
        removeProduct();
    });
    

    document.getElementById('cancel-remove').addEventListener('click', function () {
        removeProductModal.style.display = 'none';
    });


    function fetchProductDetails(productId) {
        fetch(`../data/products/products.json`)
            .then(response => response.json())
            .then(data => {
                const product = data.find(item => item.id === productId);
                if (product) {
                    document.getElementById('edit-id').value = product.id;
                    document.getElementById('edit-name').value = product.name;
                    document.getElementById('edit-category').value = product.category;
                    document.getElementById('edit-price').value = product.price;
                    document.getElementById('current-image-name').textContent = product.image; // Update current image name
                    document.getElementById('edit-description').value = product.description;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function addNewProduct() {
        const formData = new FormData(document.getElementById('add-item-form'));
        fetch('../helpers/addProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Product added successfully!');
                location.reload();
            } else {
                showMessage('Failed to add product. Please try again.', true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while adding the product.', true);
        });
    }
    
    function updateProduct() {
        const formData = new FormData(document.getElementById('edit-product-form'));
        fetch('../helpers/updateProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Product updated successfully!');
                location.reload();
            } else {
                showMessage('Failed to update product: ' + (data.message || 'Unknown error'), true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while updating the product.', true);
        });
    }
    
    function removeProduct() {
        fetch(`../helpers/removeProduct.php?id=${currentProductId}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Product removed successfully!');
                location.reload();
            } else {
                showMessage('Failed to remove product. Please try again.', true);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while removing the product.', true);
        });
    }
    


    function showMessage(message, isError = false) {
        const messageContainer = document.getElementById('message-container');
        messageContainer.textContent = message;
        messageContainer.className = isError ? 'message-container error' : 'message-container success';
        messageContainer.style.display = 'block';
        setTimeout(() => {
            messageContainer.style.display = 'none';
        }, 5000);
    }
    

    function fetchProductDetails(productId) {
        fetch(`../helpers/getProductDetails.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-category').value = data.category;
                document.getElementById('edit-price').value = data.price;
                document.getElementById('current-image-name').textContent = data.image; // Update current image name
                document.getElementById('edit-description').value = data.description;
            })
            .catch(error => console.error('Error:', error));
    }

    function addNewProduct() {
        const formData = new FormData(document.getElementById('add-item-form'));
        fetch('../helpers/addProduct.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Product added successfully!');
                    location.reload();
                } else {
                    showMessage('Failed to add product. Please try again.', true);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateProduct() {
        const formData = new FormData(document.getElementById('edit-product-form'));
        fetch('../helpers/updateProduct.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Product updated successfully!');
                    location.reload(); // Reload the page after update
                } else {
                    showMessage('Failed to update product: ' + (data.message || 'Unknown error'), true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred while updating the product.', true);
            });
    }

    function removeProduct() {
        fetch(`../helpers/removeProduct.php?id=${currentProductId}`, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Product removed successfully!');
                    location.reload();
                } else {
                    showMessage('Failed to remove product. Please try again.', true);
                }
            })
            .catch(error => console.error('Error:', error));
    }
});