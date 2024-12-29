let currentProduct = null;
const modal = document.getElementById('productModal');

function showProductModal(product) {
    currentProduct = product;
    document.getElementById('modalImage').src = product.image_url;
    document.getElementById('modalName').textContent = product.name;
    document.getElementById('modalPrice').textContent = formatPrice(product.price);
    document.getElementById('modalDescription').textContent = product.description || 'Không có mô tả';
    document.getElementById('quantity').value = 1;
    modal.style.display = 'block';
}

function addToCart() {
    if (!currentProduct) return;
    
    const quantity = parseInt(document.getElementById('quantity').value);
    if (quantity < 1) {
        alert('Vui lòng chọn số lượng hợp lệ');
        return;
    }

    const cartItem = {
        id: currentProduct.id,
        name: currentProduct.name,
        price: currentProduct.price,
        image_url: currentProduct.image_url,
        quantity: quantity
    };

    // Get existing cart items
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const existingItemIndex = cartItems.findIndex(item => item.id === cartItem.id);

    if (existingItemIndex > -1) {
        cartItems[existingItemIndex].quantity += quantity;
    } else {
        cartItems.push(cartItem);
    }

    // Save to localStorage
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    
    // Update cart count
    updateCartCount();
    
    // Close modal and show success message
    modal.style.display = 'none';
    alert('Đã thêm sản phẩm vào giỏ hàng!');
}

function updateCartCount() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelector('.cart-count').textContent = totalItems;
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', { 
        style: 'currency', 
        currency: 'VND' 
    }).format(price);
}

// Close modal when clicking the close button or outside the modal
document.querySelector('.close-modal').onclick = () => modal.style.display = 'none';
window.onclick = (event) => {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Initialize cart count when page loads
document.addEventListener('DOMContentLoaded', updateCartCount);
