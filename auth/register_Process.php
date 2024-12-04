<?php
require '../config/db_conn.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('registering user'.print_r($_POST, true));
    $name = $_POST['register_name'];
    $email = $_POST['register_email'];
    $password = password_hash($_POST['register_password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Registration failed. Please try again.';
    }

    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>