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
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<head>
    
</head>
<body>
<header>
        <!-- Logout button -->
        <button onclick="logout()" type="button" style="float: right;">Logout</button>
        <h1>Task Allocation</h1>
    </header>

    <div class="container">
        <form action="process_task.php" method="post">
        <h2 style="color: #333; text-align: center;">Assign Task</h2>
        <label for="task" style="display: block; margin: 10px 0 5px; text-align: left; color: #555;">Task:</label>
    <input type="text" name="task" value="<?php echo $task; ?>" required style="width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">

    <label for="employee" style="display: block; margin: 10px 0 5px; text-align: left; color: #555;">Assign to Employee:</label>
    <select name="employee" required style="width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
        <?php
            // Fetch employees with designations from the database
            $sql = "SELECT e.id, e.fname, d.desig_type
                    FROM employee e
                    INNER JOIN designation d ON e.desig_id = d.desig_id";
            $result = $conn->query($sql);

            // Display employees in dropdown
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $employee) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . $row['fname'] . " - " . $row['desig_type'] . "</option>";
            }
        ?>
    </select>

    <button type="submit" style="background-color: #0074D9; color: #fff; cursor: pointer; width: 100%; padding: 8px; border: none; border-radius: 4px; font-size: 14px;">Assign Task</button>
        </form>
    </div>
</body>
</html>