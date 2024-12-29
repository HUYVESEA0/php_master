<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/sign_log.php');
    exit();
}

// Check if user role is correct
if ($_SESSION['role'] === 'admin') {
    header('Location: ../Admin/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <p>This is the user dashboard</p>
    <a href="../auth/logout.php">Logout</a>
</body>
</html>
