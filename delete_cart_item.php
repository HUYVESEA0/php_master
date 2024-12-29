<?php
require_once 'Admin/fucn.php';

header('Content-Type: application/json');

function logError($message, $data = null) {
    error_log(sprintf(
        "[Cart Delete Error] %s | Data: %s", 
        $message,
        json_encode($data)
    ));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        // Log full request data
        error_log("Cart delete request data: " . $input);
        
        if (!isset($data['cart_item_id'])) {
            throw new Exception('Thiếu ID sản phẩm');
        }

        $cart_item_id = trim($data['cart_item_id']);

        if (empty($cart_item_id)) {
            throw new Exception('ID sản phẩm không được để trống');
        }

        $conn = connect();
        
        // Simple validation - allow alphanumeric and basic special chars
        if (!preg_match('/^[A-Za-z0-9\-_]+$/', $cart_item_id)) {
            logError("Invalid ID format", ['id' => $cart_item_id]);
            throw new Exception('Định dạng ID không hợp lệ');
        }

        // Check if product exists in cart_items table
        $check_sql = "SELECT COUNT(*) FROM cart_items WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        
        if (!$check_stmt) {
            logError("Database error (prepare)", ['error' => $conn->error]);
            throw new Exception('Lỗi database');
        }

        $check_stmt->bind_param("s", $cart_item_id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count === 0) {
            logError("Product not found", ['id' => $cart_item_id]);
            throw new Exception('Sản phẩm không tồn tại trong giỏ hàng');
        }

        // Delete the item
        $delete_stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $delete_stmt->bind_param("s", $cart_item_id);
        
        if (!$delete_stmt->execute()) {
            throw new Exception('Lỗi khi xóa sản phẩm');
        }

        $delete_stmt->close();
        $conn->close();

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        logError($e->getMessage(), ['trace' => $e->getTraceAsString()]);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Phương thức không hợp lệ'
    ]);
}
