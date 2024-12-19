<?php
$conn;
function connect()
{
    $conn = mysqli_connect('localhost', 'huyviesea', 'huyviesea_db', 'data_center') or die('Không thể kết nối!');
    mysqli_set_charset($conn, 'utf8');
    return $conn;
}

function disconnect($conn)
{
    mysqli_close($conn);
}

function generateRandomId($length = 6)
{
    return substr(md5(uniqid(mt_rand(), true)), 0, $length);
}

function addCategory($categoryName)
{
    $conn = connect();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM product_categories WHERE name = ?");
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $response = array('success' => false, 'message' => '');

    if ($count > 0) {
        $response['message'] = 'Danh mục đã tồn tại. Vui lòng nhập danh mục khác.';
    } else {
        $categoryId = generateRandomId();
        $stmt = $conn->prepare("INSERT INTO product_categories (id, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $categoryId, $categoryName);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Thêm danh mục thành công!';
            $response['categoryId'] = $categoryId;

            // Tạo thư mục mới trùng với ID của danh mục
            $dirPath = __DIR__ . '/upload/' . $categoryId;
            if (!file_exists($dirPath)) {
                if (!mkdir($dirPath, 0777, true)) {
                    $response['message'] .= ' nhưng không thể tạo thư mục.';
                } else {
                    $response['message'] .= ' và thư mục đã được tạo.';
                }
            } else {
                $response['message'] .= ' và thư mục đã tồn tại.';
            }
        } else {
            $response['message'] = 'Thêm danh mục thất bại. Vui lòng thử lại.';
        }

        $stmt->close();
    }

    disconnect($conn);

    return $response;
}

function addProduct($productName, $categoryId, $price, $description, $images, $quantity)
{
    $conn = connect();
    $productId = generateRandomId();
    $stmt = $conn->prepare("INSERT INTO products (id, name, category_id, price, description, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $productId, $productName, $categoryId, $price, $description, $quantity);

    $response = array('success' => false, 'message' => '');

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Thêm sản phẩm thành công!';
        $response['productId'] = $productId;

        // Tạo thư mục chứa hình ảnh sản phẩm
        $productDir = __DIR__ . '/upload/' . $categoryId . '/' . $productId;
        if (!file_exists($productDir)) {
            mkdir($productDir, 0777, true);
        }

        // Upload hình ảnh
        foreach ($images['name'] as $key => $imageName) {
            if ($key >= 6) break; // Giới hạn tối đa 6 hình ảnh
            $imageName = generateRandomId() . '_' . basename($imageName); // Đảm bảo tên file là duy nhất
            $targetFile = $productDir . '/' . $imageName;
            if (move_uploaded_file($images['tmp_name'][$key], $targetFile)) {
                // Bạn có thể lưu thông tin hình ảnh vào cơ sở dữ liệu nếu cần
            } else {
                $response['message'] .= ' Không thể tải lên hình ảnh: ' . $imageName;
            }
        }
    } else {
        $response['message'] = 'Thêm sản phẩm thất bại. Vui lòng thử lại.';
    }

    $stmt->close();
    disconnect($conn);

    return $response;
}

function getCategories()
{
    $conn = connect();
    $stmt = $conn->prepare("SELECT id, name FROM product_categories");
    $stmt->execute();
    $stmt->bind_result($id, $name);

    $categories = array();
    while ($stmt->fetch()) {
        $categories[] = array('id' => $id, 'name' => $name);
    }

    $stmt->close();
    disconnect($conn);

    return $categories;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'addCategory') {
        $categoryName = $_POST['categoryName'];
        echo json_encode(addCategory($categoryName));
    } elseif (isset($_POST['action']) && $_POST['action'] == 'addProduct') {
        $productName = $_POST['productName'];
        $categoryId = $_POST['categoryId'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $images = $_FILES['images'];
        $quantity = $_POST['quantity'];

        echo json_encode(addProduct($productName, $categoryId, $price, $description, $images, $quantity));
    } elseif (isset($_POST['action']) && $_POST['action'] == 'getCategories') {
        echo json_encode(getCategories());
    }
}
?>