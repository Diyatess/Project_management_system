<?php
// Include your database connection code here
include('../conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get task details from the form
    $task = $_POST['task'];
    $employeeId = $_POST['employee'];

    // Insert task into the database (replace 'tasks' with your actual table name)
    $insertSql = "INSERT INTO tasks (task, employee_id) VALUES ('$task', '$employeeId')";
    if ($conn->query($insertSql) === TRUE) {
        echo "Task assigned successfully!";
    } else {
        echo "Error assigning task: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>




<?php
// Include your database connection code here
include('../conn.php');

// Initialize variables
$task = $employee = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form data
    $task = isset($_POST['task']) ? htmlspecialchars($_POST['task']) : '';
    $employee = isset($_POST['employee']) ? intval($_POST['employee']) : 0;

    // Insert the task assignment into the database
    $sql = "INSERT INTO task_assignments (task, employee_id) VALUES ('$task', $employee)";
    if ($conn->query($sql) === TRUE) {
        echo "Task assigned successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

