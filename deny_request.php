<?php
session_start();
include('../conn.php'); 

if (isset($_GET['request_id'])) {
    $requestId = $_GET['request_id'];

    // Update the status of the request to "Denied" in the database
    $sql = "UPDATE project_requests SET status = 'Rejected' WHERE request_id = $requestId";
    $conn->query($sql);

    // Redirect back to the Team Lead's profile page
    header("Location: tdashboard.php");
    exit;
}
?>
