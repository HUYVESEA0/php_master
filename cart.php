<?php
require_once 'Admin/fucn.php';
$conn = connect();

// Fetch cart items from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="./css/cart.css">
    <title>Giỏ hàng - SINH DƯỢC SHOP</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <div class="cart-container">
            <h1>Giỏ hàng của bạn</h1>
            
            <div class="cart-items" id="cart-items">
                <!-- Cart items will be loaded by JavaScript -->
            </div>

            <div class="cart-summary">
                <div class="summary-item">
                    <span>Tổng sản phẩm:</span>
                    <span id="total-items">0</span>
                </div>
                <div class="summary-item">
                    <span>Tổng tiền:</span>
                    <span id="total-price">0 ₫</span>
                </div>
                <button class="checkout-button" onclick="proceedToCheckout()">
                    <i class="ri-shopping-bag-line"></i>
                    Tiến hành thanh toán
                </button>
                <button class="back-button" onclick="history.back()">
                    <i class="ri-arrow-left-line"></i>
                    Quay lại
                </button>
            </div>
        </div>
    </main>

    <script src="./js/cart.js"></script>
</body>
</html>
