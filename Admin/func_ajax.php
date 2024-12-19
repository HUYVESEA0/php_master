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
        $stmt = $conn->prepare("INSERT INTO product_categories (name) VALUES (?)");
        $stmt->bind_param("s", $categoryName);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Thêm danh mục thành công!';
        } else {
            $response['message'] = 'Thêm danh mục thất bại. Vui lòng thử lại.';
        }

        $stmt->close();
    }

    disconnect($conn);

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'addCategory') {
    $categoryName = $_POST['categoryName'];
    echo json_encode(addCategory($categoryName));
}
?>