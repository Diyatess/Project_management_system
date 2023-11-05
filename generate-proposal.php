<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process user input
    $projectTitle = $_POST["project_title"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Check if the input is not empty
    if (empty($projectTitle) || empty($startDate) || empty($endDate)) {
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
                    "content" => "create a software project proposal"
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
        $headers[] = 'Authorization: Bearer API KEY';// change API Key with the api key that we are creating

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
    <title>Generated Proposal</title>
</head>
<body>
    <h1>Generated Software Project Proposal</h1>
</body>
</html>
