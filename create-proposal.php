<?php
session_start();

include('../conn.php'); // Include your database connection code

// Extract request_id from the URL
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Update the status of the request to "Approved" in the database
    $updateStatusSql = "UPDATE project_requests SET status = 'Approved' WHERE request_id = ?";

    if ($stmt = $conn->prepare($updateStatusSql)) {
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Handle the database connection error
        echo "Error: " . $conn->error;
        exit; // Exit on error
    }

    // Fetch associated request details and client information from the database
    $sql = "SELECT project_name, project_description FROM project_requests WHERE request_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->bind_result($projectName, $projectDescription); // Correct variable name
        $stmt->fetch();
        $stmt->close();
    } else {
        // Handle the database connection error
        echo "Error: " . $conn->error;
        exit; // Exit on error
    }
} else {
    // Handle the case where request_id is not provided
    echo "Request ID is missing.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process user input
    $projectTitle = $_POST["project_title"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];
    $projectDescription = $_POST["project_description"]; // Correct variable name
    $modules = $_POST["modules"];

    // Check if the input is not empty
    if (empty($projectTitle) || empty($startDate) || empty($endDate) || empty($projectDescription) || empty($modules)) {
        echo "Please fill in all the required fields.";
    } else {
        // Proceed with creating a software project proposal
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $postdata = array(
            "model" => "gpt-3.5-turbo",
            "messages" => [
                array(
                    "role" => "system",
                    "content" => "create a software project proposal with Objectives, Life Span, $projectDescription, scope, Timeline,features, $modules"
                ),
                array(
                    "role" => "user",
                    "content" => "Project Title: $projectTitle"
                ),
                array(
                    "role" => "user",
                    "content" => "Start Date: $startDate"
                ),
                array(
                    "role" => "user",
                    "content" => "End Date: $endDate"
                ),
            ],
            "temperature" => 0.7, // Adjust temperature for creativity
            "max_tokens" => 1000, // Limit the proposal length
        );
        $postdata = json_encode($postdata);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer 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'; // Replace with your OpenAI API key

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($result, true);

        // Extract the proposal content from the response
        $proposalContent = $result['choices'][0]['message']['content'];

        // Create the PDF
        require_once('../tcpdf/tcpdf.php'); // Adjust the path as needed
        $pdf = new TCPDF();
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdfContent = "
        <h1>Software Project Proposal</h1>
        <h2>Project Title: $projectTitle</h2>
        <p>Start Date: $startDate</p>
        <p>End Date: $endDate</p>
        <div style='border: 1px solid #ccc; padding: 10px; border-radius: 5px; background-color: #f5f5f5; margin-top: 20px;'>
            " . nl2br($proposalContent) . "
        </div>
        ";
        $pdf->writeHTML($pdfContent, true, false, true, false, '');

        // Output the PDF for download
        $pdf->Output('proposal.pdf', 'D');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Project Proposal</title>
    <style>
         <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin: -14px;
        }
        h1 {
            font-size: 24px;
        }
        .container {
            max-width: 800px;
            margin: 14px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        .back-button {
            background-color: #555;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
    <header>
        <a href="javascript:history.back()" class="back-button" style="float: right;">Back</a>
        <h1>Create a Software Project Proposal Draft</h1>
    </header>
    <div class="container">
        <form method="post" action="">
            <label for="project_title">Project Title:</label>
            <input type="text" name="project_title" id="project_title" value="<?php echo $projectName; ?>" required>
            <br>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
            <br>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required>
            <br>
            <label for="project_description">Project Description:</label>
            <input type="text" name="project_description" id="project_description" value="<?php echo $projectDescription; ?>" required>
            <br>
            <label for="modules">Modules:</label>
            <input type="text" name="modules" id="modules" required>
            <br>
            <input type="submit" value="Generate Proposal">
        </form>
    </div>
</body>
</html>
