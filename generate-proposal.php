<?php
include('../conn.php'); 

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
                    "content" => "create a software project proposal with $modules, Objectives, Life Span, $projectDescription, scope, Timeline,features"
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
            "max_tokens" => 1500, // Limit the proposal length
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
       // Extract the proposal content from the response
       $proposalContent = $result['choices'][0]['message']['content'];
       
       // Start a session (if not already started)
       session_start();

       // Store the proposal content in a session variable
       $_SESSION['proposalContent'] = $proposalContent;

       // Redirect to the second page to display the content
       header('Location: display_proposal.php');
       exit;
   }
}
?>