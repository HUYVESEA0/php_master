<?php
require_once '../Admin/fucn.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $conn = connect();
    $productId = mysqli_real_escape_string($conn, $productId);

    $sql = "SELECT COUNT(*) as count FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    echo json_encode(['exists' => $row['count'] > 0]);

    disconnect($conn);
} else {
    echo json_encode(['exists' => false]);
}
?>
