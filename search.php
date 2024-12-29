<?php
require_once 'Admin/fucn.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$conn = connect();

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN product_categories c ON p.category_id = c.id 
            WHERE p.name LIKE '%$search%' 
            OR p.description LIKE '%$search%' 
            OR c.name LIKE '%$search%'";
    
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - <?php echo htmlspecialchars($search); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="container">
        <h1>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($search); ?>"</h1>
        
        <?php if (!empty($search)): ?>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="search-results">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="product-card">
                            <?php if (!empty($row['image'])): ?>
                                <img src="/my_proj/upload/<?php echo $row['category_id']; ?>/<?php echo $row['id']; ?>/<?php echo $row['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p class="category"><?php echo htmlspecialchars($row['category_name']); ?></p>
                            <p class="price"><?php echo number_format($row['price']); ?> VNĐ</p>
                            <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <form action="delete_product.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Không tìm thấy sản phẩm nào phù hợp.</p>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <script src="./index.js"></script>
</body>
</html>
