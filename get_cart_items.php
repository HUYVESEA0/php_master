<?php
require_once 'Admin/fucn.php';
$conn = connect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT ci.*, SUM(ci.quantity) as total_items 
          FROM cart_items ci 
          GROUP BY ci.id";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$cart_items = array();
$total_items = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_items += intval($row['quantity']);
}

echo json_encode([
    'items' => $cart_items,
    'total_items' => $total_items
]);
?>
