const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
document.querySelector('.cart-count').textContent = totalItems;

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
