<?php
// Connect to the database (replace with your database connection code)
include('../conn.php');
// Include the TCPDF library (download it and place it in your project directory)
require_once('../tcpdf/tcpdf.php');

// Fetch the request ID from the URL 
if (isset($_GET['request_id'])) {
    $requestID = $_GET['request_id'];
} else {
    // Handle the case where request_id is not provided in the URL
    // You can add an error message or redirect the user
    die("Request ID not provided.");
}

// Fetch data from the project_requests and clients tables
$sql = "SELECT pr.client_email, c.cname, pr.project_name, pr.start_date, pr.end_date
        FROM project_requests pr
        INNER JOIN client c ON pr.client_email = c.email
        WHERE pr.request_id = $requestID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $clientEmail = $row["client_email"];
    $clientName = $row["cname"];
    $projectTitle = $row["project_name"];
    $startDate = $row["start_date"];
    $endDate = $row["end_date"];
} else {
    // Handle the case where the data is not found
    die("Project data not found.");
}

// Close the database connection
$conn->close();

// Create a new PDF document
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(true, 15);

// Add a page
$pdf->AddPage();

// Set the content
$pdf->SetFont('helvetica', '', 12);

// Define your PDF content with a text-based letterhead and simplified styling
$pdfContent = "
<div >
        <p>Date: [Current Date]</p>
    </div>

    <h1>Software Project Proposal</h1>

    <!-- Client Information -->
    <p>Client: '<?php echo $clientName ?>'</p>
    <p>Client's Company: [Client's Company]</p>
    <p>Client Email:'<?php echo $clientEmail ?>'</p>

    <p>Subject: Software Project Proposal</p>

    <p>Dear '<?php echo $clientName ?>',</p>

    <p>We appreciate the opportunity to submit this proposal for your software development project. Our team is excited to work with [Client's Company] to develop a custom software solution that will meet your specific needs and objectives.</p>

    <h2>Project Overview:</h2>
    <p>Project Title: '<?php echo $projectTitle ?>'</p>
    <p>Project Duration: '<?php echo $startDate ?>' to '<?php echo $endDate ?>'</p>
    <p>Project Budget: [Total Budget]</p>

    <h2>Project Objectives:</h2>
    <ol>
        <li>[Objective 1]
            <ul>
                <li>[Details and deliverables related to Objective 1]</li>
            </ul>
        </li>
        <li>[Objective 2]
            <ul>
                <li>[Details and deliverables related to Objective 2]</li>
            </ul>
        </li>
        <li>[Objective 3]
            <ul>
                <li>[Details and deliverables related to Objective 3]</li>
            </ul>
        </li>
    </ol>

    <h2>Scope of Work:</h2>
    <p>We will be responsible for the following tasks:</p>
    <ul>
        <li>Task 1: [Description]</li>
        <li>Task 2: [Description]</li>
        <li>Task 3: [Description]</li>
    </ul>

    <h2>Software Features:</h2>
    <p>Our solution will include the following features:</p>
    <ul>
        <li>Feature 1: [Description]</li>
        <li>Feature 2: [Description]</li>
        <li>Feature 3: [Description]</li>
    </ul>

    <h2>Methodology:</h2>
    <p>We will employ [Methodology Name] to ensure an efficient and organized project execution.</p>

    <h2>Timeline:</h2>
    <p>We have divided the project into various phases, and the estimated timeline is as follows:</p>
    <ul>
        <li>Phase 1: [Start Date] to [End Date]</li>
        <li>Phase 2: [Start Date] to [End Date]</li>
        <li>Phase 3: [Start Date] to [End Date]</li>
    </ul>

    <h2>Budget Breakdown:</h2>
    <p>Development Costs: $[Amount]</p>
    <p>Testing and Quality Assurance: $[Amount]</p>
    <p>Project Management: $[Amount]</p>
    <p>Contingency: $[Amount]</p>
    <p>Total Budget: $[Total Amount]</p>

    <h2>Payment Schedule:</h2>
    <ul>
        <li>Initial Payment: $[Amount] upon project initiation</li>
        <li>Milestone Payment 1: $[Amount] upon completion of Phase 1</li>
        <li>Milestone Payment 2: $[Amount] upon completion of Phase 2</li>
        <li>Final Payment: $[Amount] upon project completion</li>
    </ul>

    <h2>Terms and Conditions:</h2>
    <p>[Include any terms and conditions or legal details]</p>

    <p>We are confident that our team's expertise and commitment will result in the successful completion of this project. We look forward to discussing this proposal further and addressing any questions or concerns you may have.</p>

    <p>Thank you for considering our proposal.</p>

    <p>Sincerely,</p>
    <p>Diya Tes</p>
    <p>Team Lead</p>
    <p>Taskmaster Hub</p>
    <p>taskmasterhub2023@gmail.com</p>
";

// Set the content with HTML support
$pdf->writeHTML($pdfContent, true, false, true, false, '');

// Output the PDF to the client
$pdf->Output('proposal.pdf', 'D');

// Exit to prevent any further content from being sent to the client
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Project Proposal</title>
    <style>
        /* Your CSS styling here */
    </style>
</head>
<body>
    <!-- Your Company Letterhead -->
    <div class="letterhead">
        <img src="company_logo.png" alt="Your Company Logo" width="200">
        <p>Date: [Current Date]</p>
    </div>

    <h1>Software Project Proposal</h1>

    <!-- Client Information -->
    <p>Client: '<?php echo $clientName ?>'</p>
    <p>Client's Company: [Client's Company]</p>
    <p>Client Email:'<?php echo $clientEmail ?>'</p>

    <p>Subject: Software Project Proposal</p>

    <p>Dear '<?php echo $clientName ?>',</p>

    <p>We appreciate the opportunity to submit this proposal for your software development project. Our team is excited to work with [Client's Company] to develop a custom software solution that will meet your specific needs and objectives.</p>

    <h2>Project Overview:</h2>
    <p>Project Title: '<?php echo $projectTitle ?>'</p>
    <p>Project Duration: '<?php echo $startDate ?>' to '<?php echo $endDate ?>'</p>
    <p>Project Budget: [Total Budget]</p>

    <h2>Project Objectives:</h2>
    <ol>
        <li>[Objective 1]
            <ul>
                <li>[Details and deliverables related to Objective 1]</li>
            </ul>
        </li>
        <li>[Objective 2]
            <ul>
                <li>[Details and deliverables related to Objective 2]</li>
            </ul>
        </li>
        <li>[Objective 3]
            <ul>
                <li>[Details and deliverables related to Objective 3]</li>
            </ul>
        </li>
    </ol>

    <h2>Scope of Work:</h2>
    <p>We will be responsible for the following tasks:</p>
    <ul>
        <li>Task 1: [Description]</li>
        <li>Task 2: [Description]</li>
        <li>Task 3: [Description]</li>
    </ul>

    <h2>Software Features:</h2>
    <p>Our solution will include the following features:</p>
    <ul>
        <li>Feature 1: [Description]</li>
        <li>Feature 2: [Description]</li>
        <li>Feature 3: [Description]</li>
    </ul>

    <h2>Methodology:</h2>
    <p>We will employ [Methodology Name] to ensure an efficient and organized project execution.</p>

    <h2>Timeline:</h2>
    <p>We have divided the project into various phases, and the estimated timeline is as follows:</p>
    <ul>
        <li>Phase 1: [Start Date] to [End Date]</li>
        <li>Phase 2: [Start Date] to [End Date]</li>
        <li>Phase 3: [Start Date] to [End Date]</li>
    </ul>

    <h2>Budget Breakdown:</h2>
    <p>Development Costs: $[Amount]</p>
    <p>Testing and Quality Assurance: $[Amount]</p>
    <p>Project Management: $[Amount]</p>
    <p>Contingency: $[Amount]</p>
    <p>Total Budget: $[Total Amount]</p>

    <h2>Payment Schedule:</h2>
    <ul>
        <li>Initial Payment: $[Amount] upon project initiation</li>
        <li>Milestone Payment 1: $[Amount] upon completion of Phase 1</li>
        <li>Milestone Payment 2: $[Amount] upon completion of Phase 2</li>
        <li>Final Payment: $[Amount] upon project completion</li>
    </ul>

    <h2>Terms and Conditions:</h2>
    <p>[Include any terms and conditions or legal details]</p>

    <p>We are confident that our team's expertise and commitment will result in the successful completion of this project. We look forward to discussing this proposal further and addressing any questions or concerns you may have.</p>

    <p>Thank you for considering our proposal.</p>

    <p>Sincerely,</p>
    <p>Diya Tes</p>
    <p>Team Lead</p>
    <p>Taskmaster Hub</p>
    <p>taskmasterhub2023@gmail.com</p>
</body>
</html>
