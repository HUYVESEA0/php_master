<?php
require_once 'Admin/fucn.php';
$conn = connect();

// Check if category is selected
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Validate category_id
if ($category_id) {
    $category_check_sql = "SELECT COUNT(*) FROM product_categories WHERE id = $category_id";
    $category_check_result = mysqli_query($conn, $category_check_sql);
    $category_exists = mysqli_fetch_array($category_check_result)[0] > 0;
    if (!$category_exists) {
        $category_id = 0;
    }
}

// Modify product query to filter by category
$product_sql = $category_id ? "SELECT * FROM products WHERE category_id = $category_id" : "SELECT * FROM products";
$products = mysqli_query($conn, $product_sql);

include 'includes/header.php';
?>
      <main>
         <div class="products-container">
            <?php while($product = mysqli_fetch_assoc($products)) { ?>
               <div class="product-card">
                  <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                  <h3 class="product-name"><?php echo $product['name']; ?></h3>
                  <p class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                  <button class="buy-button" onclick="showProductModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                     <i class="ri-shopping-cart-line"></i> Mua hàng
                  </button>
               </div>
            <?php } ?>
         </div>

         <!-- Product Modal -->
         <div id="productModal" class="modal">
            <div class="modal-content">
               <span class="close-modal">&times;</span>
               <div class="modal-body">
                  <div class="product-details">
                     <img id="modalImage" src="" alt="" class="modal-image">
                     <div class="product-info">
                        <h2 id="modalName"></h2>
                        <p id="modalPrice" class="modal-price"></p>
                        <p id="modalDescription" class="modal-description"></p>
                        <div class="quantity-selector">
                           <label for="quantity">Số lượng:</label>
                           <input type="number" id="quantity" min="1" value="1">
                        </div>
                        <div class="modal-buttons">
                           <button class="add-to-cart-button" onclick="addToCart()">
                              <i class="ri-shopping-cart-line"></i> Thêm vào giỏ
                           </button>
                           <button class="confirm-buy-button" onclick="confirmPurchase()">
                              <i class="ri-shopping-bag-line"></i> Mua ngay
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <script src="./index.js"></script>
      <script src="./js/search.js"></script>
      <script src="./js/modal.js"></script>
   </body>
</html>