<?php
include('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form data
    $task = isset($_POST['task']) ? htmlspecialchars($_POST['task']) : '';
    $employeeId = isset($_POST['employee']) ? intval($_POST['employee']) : 0;

    // Insert task into the database (replace 'tasks' with your actual table name)
    $insertSql = "INSERT INTO task (task_description, assigned_to) VALUES ('$task', '$employeeId')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Task assigned successfully!";
    } else {
        echo "Error assigning task: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
