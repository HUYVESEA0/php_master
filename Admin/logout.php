<?php
session_start();
session_destroy();
header("Location: ../index.php"); // Changed from ./index.php to ../index.php
exit();
?>
