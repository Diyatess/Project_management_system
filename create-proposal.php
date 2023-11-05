<?php
session_start();

// Check if the user is authenticated as a team lead

include('../conn.php'); // Include your database connection code

// Extract request_id from the URL
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    

    // Fetch associated request details and client information from the database
    $sql = "SELECT project_name FROM project_requests WHERE request_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->bind_result($projectName);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Handle the database connection error
        echo "Error: " . $conn->error;
    }
} else {
    // Handle the case where request_id is not provided
    echo "Request ID is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Project Proposal</title>
</head>
<body>
    <h1>Create a Software Project Proposal</h1>
    <form method="post" action="generate-proposal.php">
        <label for="project_title">Project Title:</label>
        <input type="text" name="project_title" id="project_title" value="<?php echo $projectName; ?>" required>
        <br>
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>
        <br>
        <label for= "end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>
        <br>
        <input type="submit" value="Generate Proposal">
    </form>
</body>
</html>