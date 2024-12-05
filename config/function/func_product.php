<?php
require_once '../config/db_conn.php';

function getProductCategories($conn) {
    $sql = "SELECT * FROM product_categories";
    $result = $conn->query($sql);
    return $result;
}

function getProducts($conn) {
    $sql = "SELECT p.product_id, p.product_name, c.category_name, p.price, p.stock, p.description, p.image_url
            FROM products p
            JOIN product_categories c ON p.category_id = c.category_id";
    $result = $conn->query($sql);
    return $result;
}

function addProduct($conn, $product_name, $category_id, $price, $stock, $description, $image_url) {
    $sql = "INSERT INTO products (product_name, category_id, price, stock, description, image_url)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidiss", $product_name, $category_id, $price, $stock, $description, $image_url);
    return $stmt->execute();
}

function updateProduct($conn, $product_id, $product_name, $category_id, $price, $stock, $description, $image_url) {
    $sql = "UPDATE products SET product_name = ?, category_id = ?, price = ?, stock = ?, description = ?, image_url = ?
            WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidissi", $product_name, $category_id, $price, $stock, $description, $image_url, $product_id);
    return $stmt->execute();
}

function deleteProduct($conn, $product_id) {
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    return $stmt->execute();
}

function addGroup($conn, $group_name) {
    $sql = "INSERT INTO product_categories (category_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $group_name);
    $stmt->execute();
    return $conn->insert_id; // Return the ID of the newly created group
}
?>