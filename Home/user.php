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
