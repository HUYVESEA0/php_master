<?php
require_once 'Admin/fucn.php';
session_start();

header('Content-Type: application/json');

try {
    $conn = connect();
    $input = json_decode(file_get_contents('php://input'), true);
    $cart_items = $input['cart_items'] ?? [];
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        throw new Exception('Người dùng chưa đăng nhập');
    }

    // Begin transaction
    $conn->begin_transaction();

    // Clear existing cart items
    $clear_sql = "DELETE FROM cart_items WHERE cart_id IN (SELECT id FROM cart WHERE user_id = ?)";
    $clear_stmt = $conn->prepare($clear_sql);
    $clear_stmt->bind_param('s', $user_id);
    $clear_stmt->execute();

    // Get or create cart
    $cart_sql = "SELECT id FROM cart WHERE user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param('s', $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();
    
    if ($cart_row = $cart_result->fetch_assoc()) {
        $cart_id = $cart_row['id'];
    } else {
        $cart_id = substr(uniqid(), 0, 6);
        $create_cart_sql = "INSERT INTO cart (id, user_id) VALUES (?, ?)";
        $create_cart_stmt = $conn->prepare($create_cart_sql);
        $create_cart_stmt->bind_param('ss', $cart_id, $user_id);
        $create_cart_stmt->execute();
    }

    // Insert new cart items
    if (!empty($cart_items)) {
        $insert_sql = "INSERT INTO cart_items (id, cart_id, product_id, quantity) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        
        foreach ($cart_items as $item) {
            $item_id = substr(uniqid(), 0, 6);
            $insert_stmt->bind_param('sssi', $item_id, $cart_id, $item['id'], $item['quantity']);
            $insert_stmt->execute();
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
