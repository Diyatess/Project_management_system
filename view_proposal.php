<?php
include('../conn.php');

// Check if the client's email is provided in the URL
if (isset($_GET['email'])) {
    $clientEmail = $_GET['email'];

    // Fetch the proposal details for the given client email
    $sql = "SELECT request_id, project_name, status FROM project_requests WHERE client_email = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the client's email as a parameter
    $stmt->bind_param('s', $clientEmail);

    // Execute the prepared statement
    $stmt->execute();

    // Get the results
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $requestId = $row['request_id'];
            $projectTitle = $row['project_name'];
            $proposalStatus = $row['status'];

            // Check if the proposal is approved
            if ($proposalStatus === 'Approved') {
                // Display the proposal details and provide a link to download the approved proposal
                echo "<h1>Approved Proposal: $projectTitle</h1>";
                echo "<p>Status: $proposalStatus</p>";
                echo "<p><a href='download_proposal.php?request_id=$requestId'>Download Proposal</a></p>";
            } else {
                echo "The proposal for request ID $requestId has not been approved yet.";
            }
        }
    } else {
        echo "No approved proposals found for this client.";
    }
} else {
    echo "Client email not provided.";
}
?>
