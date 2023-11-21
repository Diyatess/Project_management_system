<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Include database connection code
    include('../conn.php');

    // Delete user
    $sql = "DELETE FROM client WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect using JavaScript
        echo "<script>window.location.href = 'user_fetch.php';</script>";
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();
}
?>
