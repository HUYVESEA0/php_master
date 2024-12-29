<?php
require_once('fucn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'addCategory':
            $name = $_POST['categoryName'] ?? '';
            if (empty($name)) {
                echo json_encode(['success' => false, 'message' => 'Category name is required']);
                exit;
            }
            
            $conn = connect();
            if (!$conn) {
                echo json_encode(['success' => false, 'message' => 'Database connection failed']);
                exit;
            }
            $name = mysqli_real_escape_string($conn, $name);
            
            // Generate random 6-character ID
            do {
                $id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                $check = mysqli_query($conn, "SELECT id FROM product_categories WHERE id = '$id'");
            } while (mysqli_num_rows($check) > 0);
            
            $sql = "INSERT INTO product_categories (id, name) VALUES ('$id', '$name')";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Category added successfully']);
            } else {
                error_log('Error adding category: ' . mysqli_error($conn));
                echo json_encode(['success' => false, 'message' => 'Error adding category: ' . mysqli_error($conn)]);
            }
            
            disconnect($conn);
            break;
            
        case 'getCategories':
            $conn = connect();
            $sql = "SELECT * FROM product_categories";
            $result = mysqli_query($conn, $sql);
            $categories = [];
            
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row;
            }
            
            echo json_encode($categories);
            disconnect($conn);
            break;
            
        case 'editCategory':
            $id = $_POST['id'] ?? '';
            $name = $_POST['categoryName'] ?? '';
            
            if (empty($id) || empty($name)) {
                echo json_encode(['success' => false, 'message' => 'Category ID and name are required']);
                exit;
            }
            
            $conn = connect();
            $name = mysqli_real_escape_string($conn, $name);
            $id = mysqli_real_escape_string($conn, $id);
            
            $sql = "UPDATE product_categories SET name = '$name' WHERE id = '$id'";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating category: ' . mysqli_error($conn)]);
            }
            
            disconnect($conn);
            break;
            
        case 'deleteCategory':
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Category ID is required']);
                exit;
            }
            
            $conn = connect();
            $id = mysqli_real_escape_string($conn, $id);
            
            $sql = "DELETE FROM product_categories WHERE id = '$id'";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting category: ' . mysqli_error($conn)]);
            }
            
            disconnect($conn);
            break;

        case 'addProduct':
        case 'updateProduct':
            $id = $_POST['productId'] ?? '';
            $name = $_POST['name'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $price = $_POST['price'] ?? '';
            $description = $_POST['description'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            
            $conn = connect();
            
            if ($action === 'addProduct') {
                // Generate random 6-character ID
                do {
                    $id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                    $check = mysqli_query($conn, "SELECT id FROM products WHERE id = '$id'");
                } while (mysqli_num_rows($check) > 0);

                $sql = "INSERT INTO products (id, name, category_id, price, description, quantity) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssdi", $id, $name, $categoryId, $price, $description, $quantity);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success = handleImageUpload($id, $categoryId);
                    echo json_encode([
                        'success' => $success,
                        'message' => $success ? 'Product added successfully' : 'Product added but image upload failed'
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error adding product']);
                }
            } else {
                $sql = "UPDATE products SET name=?, category_id=?, price=?, description=?, quantity=? WHERE id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssdsii", $name, $categoryId, $price, $description, $quantity, $id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success = handleImageUpload($id, $categoryId);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Product updated successfully'
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating product']);
                }
            }
            
            mysqli_stmt_close($stmt);
            disconnect($conn);
            break;

        case 'deleteProduct':
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Product ID is required']);
                exit;
            }
            
            $conn = connect();
            
            // Get product info before deletion for image cleanup
            $sql = "SELECT category_id, image FROM products WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);
            
            // Delete product from database
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            if (mysqli_stmt_execute($stmt)) {
                // Clean up product images if they exist
                if ($product && !empty($product['image'])) {
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/my_proj/Admin/upload/{$product['category_id']}/{$id}/";
                    if (is_dir($imagePath)) {
                        array_map('unlink', glob("$imagePath/*.*"));
                        rmdir($imagePath);
                    }
                }
                echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting product: ' . mysqli_error($conn)]);
            }
            
            mysqli_stmt_close($stmt);
            disconnect($conn);
            break;

        case 'getProduct':
            $id = $_POST['id'] ?? '';
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Product ID is required']);
                exit;
            }

            $conn = connect();
            $id = mysqli_real_escape_string($conn, $id);
            $sql = "SELECT * FROM products WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($result);

            echo json_encode($product);
            disconnect($conn);
            break;

        case 'addUser':
        case 'updateUser':
            $id = $_POST['userId'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if (empty($username) || empty($email)) {
                echo json_encode(['success' => false, 'message' => 'Username and email are required']);
                exit;
            }

            $conn = connect();
            
            if ($action === 'addUser') {
                if (empty($password)) {
                    echo json_encode(['success' => false, 'message' => 'Password is required for new users']);
                    exit;
                }
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);
            } else {
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET username=?, email=?, password=?, role=? WHERE id=?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $hashedPassword, $role, $id);
                } else {
                    $sql = "UPDATE users SET username=?, email=?, role=? WHERE id=?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $role, $id);
                }
            }

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true, 'message' => ($action === 'addUser' ? 'User added' : 'User updated') . ' successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
            }

            mysqli_stmt_close($stmt);
            disconnect($conn);
            break;

        case 'deleteUser':
            $id = $_POST['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
                exit;
            }

            $conn = connect();
            $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting user']);
            }

            mysqli_stmt_close($stmt);
            disconnect($conn);
            break;
    }
}

function handleImageUpload($productId, $categoryId) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        return true;
    }

    // Create base upload directory if it doesn't exist
    $uploadBase = $_SERVER['DOCUMENT_ROOT'] . "/my_proj/Admin/upload";
    if (!file_exists($uploadBase)) {
        mkdir($uploadBase, 0777, true);
    }

    // Create category directory
    $categoryPath = $uploadBase . "/{$categoryId}";
    if (!file_exists($categoryPath)) {
        mkdir($categoryPath, 0777, true);
    }

    // Create product directory
    $productPath = "{$categoryPath}/{$productId}";
    if (!file_exists($productPath)) {
        mkdir($productPath, 0777, true);
    }

    // Get file info
    $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $newFileName = "{$productId}.{$fileExt}";
    $targetPath = "{$productPath}/{$newFileName}";

    // Remove old images
    $files = glob("{$productPath}/*");
    foreach($files as $file) {
        if(is_file($file)) {
            unlink($file);
        }
    }

    // Upload new image
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $conn = connect();
        $sql = "UPDATE products SET image = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $newFileName, $productId);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        disconnect($conn);
        return $success;
    }

    return false;
}
?>
