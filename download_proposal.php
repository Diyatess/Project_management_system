<?php
// Fetch the request ID from the URL
if (isset($_GET['request_id'])) {
    $requestId = $_GET['request_id'];

    // Query the database to get the PDF file path for the given request ID
    // Replace with your actual query to fetch the file path

    $pdfFilePath = "proposal\proposal$requestId.pdf"; // Replace with the actual file path

    // Check if the file exists
    if (file_exists($pdfFilePath)) {
        // Set the appropriate headers for PDF download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="proposal.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdfFilePath));

        // Read the file and output it for download
        readfile($pdfFilePath);
        exit;
    } else {
        echo "Proposal not found.";
    }
} else {
    echo "Request ID not provided.";
}
?>
