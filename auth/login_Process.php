<?php
session_start();
require '../config/db_conn.php';

$response = array('success' => false, 'message' => '', 'role' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role, username FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role, $username);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            $response['success'] = true;
            $response['role'] = $role;
            $response['redirect'] = $role === 'admin' ? '../Admin/admin.php' : '../Home/user.php';
        } else {
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['message'] = 'No user found with this email.';
    }

    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>