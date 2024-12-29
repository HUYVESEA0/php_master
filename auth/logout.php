<?php
session_start();
session_destroy();
header('Location: sign_log.php');
exit();
?>
