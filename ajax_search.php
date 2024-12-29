<?php
require_once 'Admin/fucn.php';

if (isset($_POST['q'])) {
    $search = trim($_POST['q']);
    $conn = connect();
    
    if (strlen($search) >= 2) {
        $search = mysqli_real_escape_string($conn, $search);
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN product_categories c ON p.category_id = c.id 
                WHERE p.name LIKE '%$search%' 
                OR p.description LIKE '%$search%' 
                LIMIT 5";
        
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="quick-search-results">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="search-item">';
                if (!empty($row['image'])) {
                    echo '<img src="/my_proj/upload/' . $row['category_id'] . '/' . $row['id'] . '/' . $row['image'] . '" alt="' . htmlspecialchars($row['name']) . '">';
                }
                echo '<div class="search-item-details">';
                echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                echo '<p class="price">' . number_format($row['price']) . ' VNĐ</p>';
                echo '</div>';
                echo '<button class="delete-product" data-id="' . $row['id'] . '">Delete</button>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="no-results">Không tìm thấy sản phẩm</div>';
        }
    }
    
    disconnect($conn);
}
?>
