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

// Xử lý thêm loại sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $conn = connect();
        $check_sql = "SELECT * FROM product_categories WHERE LOWER(name) = LOWER('$name')";
        $result = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($result) > 0) {
            echo "Tên loại sản phẩm đã tồn tại!";
        } else {
            $sql = "INSERT INTO product_categories(name) VALUES ('$name')";
            echo "<script>console.log('SQL Query: " . addslashes($sql) . "');</script>";
            if (mysqli_query($conn, $sql)) {
                echo "Thêm loại sản phẩm thành công!";
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        }
        disconnect($conn);
    }
}