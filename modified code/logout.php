<?php
session_start();
session_destroy(); // Destroy the session
header("Location: client/login_client.php"); // Redirect to the login page
exit();
?>
