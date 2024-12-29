function loadCartItems() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const cartContainer = document.querySelector('.cart-items');
    
    if (cartItems.length === 0) {
        cartContainer.innerHTML = `
            <div class="empty-cart">
                <i class="ri-shopping-cart-line" style="font-size: 3rem; color: #ccc;"></i>
                <p>Giỏ hàng của bạn đang trống</p>
            </div>
        `;
        updateCartSummary();
        return;
    }

    cartContainer.innerHTML = cartItems.map(item => `
        <div class="cart-item">
            <img src="${item.image_url}" alt="${item.name}">
            <div class="item-details">
                <h3 class="item-name">${item.name}</h3>
                <p class="item-price">${formatPrice(item.price)}</p>
                <div class="item-quantity">
                    <button class="quantity-btn" onclick="updateQuantity(${JSON.stringify(item.id)}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button class="quantity-btn" onclick="updateQuantity(${JSON.stringify(item.id)}, 1)">+</button>
                </div>
            </div>
            <button type="button" class="delete-button" onclick="removeItem(${JSON.stringify(item.id)})">
                <i class="ri-delete-bin-line"></i> Xóa
            </button>
        </div>
    `).join('');

    updateCartSummary();
}

function updateQuantity(productId, change) {
    if (!productId) {
        console.error('Invalid product ID');
        return;
    }

    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const itemIndex = cartItems.findIndex(item => String(item.id) === String(productId));
    
    if (itemIndex > -1) {
        cartItems[itemIndex].quantity = Math.max(1, cartItems[itemIndex].quantity + change);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        loadCartItems();
        updateCartCount();
    }
}

async function removeItem(productId) {
    if (!productId) return;
    
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        try {
            const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            const updatedCart = cartItems.filter(item => String(item.id) !== String(productId));
            localStorage.setItem('cartItems', JSON.stringify(updatedCart));
            
            // Sync with database
            await syncCart();
            
            loadCartItems();
            updateCartCount();
        } catch (error) {
            console.error('Error removing item:', error);
            alert('Có lỗi khi xóa sản phẩm');
        }
    }
}

function updateCartSummary() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-price').textContent = formatPrice(totalPrice);
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', { 
        style: 'currency', 
        currency: 'VND' 
    }).format(price);
}

async function checkProductExists(productId) {
    const response = await fetch(`/my_proj/api/check_product.php?id=${productId}`);
    const data = await response.json();
    return data.exists;
}

async function addToCart(product) {
    const exists = await checkProductExists(product.id);
    if (!exists) {
        alert('Sản phẩm không tồn tại trong cơ sở dữ liệu.');
        return;
    }

    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const itemIndex = cartItems.findIndex(item => item.id === product.id);

    if (itemIndex > -1) {
        cartItems[itemIndex].quantity += 1;
    } else {
        cartItems.push({ ...product, quantity: 1 });
    }

    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    await syncCart(); // Add sync after updating localStorage
    loadCartItems();
    updateCartCount();
}

function proceedToCheckout() {
    // Add checkout logic here
    alert('Chuyển đến trang thanh toán...');
}

function updateCartCount() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

// Xóa các hàm không cần thiết
// deleteCartItem và updateCartDisplay có thể xóa vì chúng ta sẽ dùng removeItem

async function syncCart() {
    try {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const response = await fetch('/my_proj/sync_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart_items: cartItems })
        });

        const data = await response.json();
        if (!data.success) {
            console.error('Sync failed:', data.error);
        }
    } catch (error) {
        console.error('Error syncing cart:', error);
    }
}

// Load cart items when page loads
document.addEventListener('DOMContentLoaded', () => {
    loadCartItems();
    updateCartCount();
    syncCart(); // Sync cart when page loads
});
