<?php
require '../config/db_conn.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $response['success'] = true;
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