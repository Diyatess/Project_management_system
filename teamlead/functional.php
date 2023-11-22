<?php
session_start();

include('../conn.php');
// Function to calculate Total Months
function calculateTotalMonths($functionPoints, $teamSize, $averageProductivity)
{
    if ($teamSize != 0 && $averageProductivity != 0) {
        $totalMonths = $functionPoints / ($teamSize * $averageProductivity);
        return $totalMonths;
    } else {
        return "Invalid input. Team size and average productivity must be non-zero.";
    }
}

// Function to calculate Total Cost
function calculateTotalCost($hourlyRate, $effort, $totalMonths, $exchangeRate)
{
    return $hourlyRate * $effort * $totalMonths * $exchangeRate;
}

// Function to calculate Functional Points
function calculateFunctionalPoints($ei, $eo, $eq)
{
    $totalEi = count(explode(",", $ei));
    $totalEo = count(explode(",", $eo));
    $totalEq = count(explode(",", $eq));

    return $totalEi + $totalEo + $totalEq;
}


// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $teamSize = $_POST["teamSize"];
    $averageProductivity = $_POST["averageProductivity"];
    $hourlyRate = $_POST["hourlyRate"];
    $effort = 5.2;
    $externalInputs = $_POST["externalInputs"];
    $externalOutputs = $_POST["externalOutputs"];
    $externalInquiries = $_POST["externalInquiries"];

    // Set the exchange rate (1 USD to INR)
    $exchangeRate = 75.0; // Replace with the actual exchange rate

    // Calculate Functional Points
    $functionalPoints = calculateFunctionalPoints($externalInputs, $externalOutputs, $externalInquiries);

    // Calculate total months
    $totalMonths = calculateTotalMonths($functionalPoints, $teamSize, $averageProductivity);

    // Calculate total cost in Indian Rupees
    $totalCostINR = calculateTotalCost($hourlyRate, $effort, $totalMonths, $exchangeRate);

    $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $postdata = array(
            "model" => "gpt-3.5-turbo",
            "messages" => [
                array(
                    "role" => "system",
                    "content" => "cerate a timeline and cost estimation for software proposal if total months is $totalMonths and total cost is $totalCostINR Indian rupees"
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
       header('Location: cost_generate.php');
       exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Total Months</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Add or modify styles as needed */
        .main-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Add or modify styles as needed */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 76px;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            text-align: left;
            padding-top: 60px;
            color: #fff;
        }

        .sidebar a {
            padding: 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
            margin: 15px 0;
        }

        .sidebar a:hover {
            background-color: #00D2FC;
            color: #fff;
        }

        h1 {
            font-size: 32px;
            color: #fff;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Style the sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 76px;
            left: -250px;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            text-align: left;
            padding-top: 60px;
            color: #fff;
        }

        .sidebar a {
            padding: 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
            margin: 15px 0;
        }

        .sidebar a:hover {
            background-color: #00D2FC;
            color: #fff;
        }

        .openbtn {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            z-index: 1;
            top: 10px;
            left: 10px;
            color: #00d2fc;
        }

        .icon {
            margin-right: 10px;
            font-size: 20px;
        }

        /* Add a background color for the links */
        .sidebar a {
            background-color: #333;
        }

        /* On hover, the background color and text color change */
        .sidebar a:hover {
            background-color: #00D2FC;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #0074D9;
        }

        a.navbar-brand {
            color: black; /* Set the text color to black */
            text-decoration: none; /* Remove the underline */
            font-weight: bold;
            color: #fff;
            font-size: 24px;
            margin-left: 45px;
            padding: 0px;

        }

        img {
            width: 39px;
            height: 39px;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 24px;
        }
    </style>
    <script>
        let sidebarOpen = false;

        function toggleSidebar() {
            const sidebar = document.getElementById("mySidebar");
            if (sidebarOpen) {
                sidebar.style.left = "-250px";
            } else {
                sidebar.style.left = "0";
            }
            sidebarOpen = !sidebarOpen;
        }
    </script>
</head>

<body>
    <a class="navbar-brand" href="../index.php" style="float: left;">
        <img src="../images/logo.png" alt="" />
        <span> TaskMasters Hub</span>
    </a>
    <header>
    <div class="openbtn" onclick="toggleSidebar()">&#9776;</div>
        <button onclick="window.location.href='tdashboard.php'" type="button" style="float: right;">Back</button>
        <h1>Calculate Total Months</h1>
    </header>
    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="add_task.php">
            <span class="icon">&#10010;</span> Add Task
        </a>
        <a href="view_status.php">
            <span class="icon">&#128196;</span> View Status
        </a>
        <a href="schedule_meeting.php">
            <span class="icon">&#9201;</span> Schedule Meeting
        </a>
        <a href="monitor_progress.php">
            <span class="icon">&#128221;</span> Monitor Daily Progress
        </a>
        <a href="view_projects.php">
            <span class="icon">&#128213;</span> View Approved/Denied Projects
        </a>
        <a href="functional.php">
            <span class="icon">📏</span> Calculate Functional Point
        </a>
    </div>

    

    <div class="main-content">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="externalInputs">External Inputs (comma-separated):</label>
    <input type="text" name="externalInputs" placeholder="e.g., input1, input2" required>

    <label for="externalOutputs">External Outputs (comma-separated):</label>
    <input type="text" name="externalOutputs" placeholder="e.g., output1, output2" required>

    <label for="externalInquiries">External Inquiries (comma-separated):</label>
    <input type="text" name="externalInquiries" placeholder="e.g., inquiry1, inquiry2" required>

    <label for="teamSize">Team Size:</label>
    <input type="number" name="teamSize" placeholder="e.g., 3" required>

    <label for="averageProductivity">Average Productivity:</label>
    <input type="number" step="0.01" name="averageProductivity" placeholder="e.g., 0.08" required>

    <label for="hourlyRate">Hourly Rate ($):</label>
    <input type="number" step="0.01" name="hourlyRate" placeholder="e.g., 100.00" required>

    <!--<label for="effort">Estimated Effort in hours (1 or above):</label>
    <input type="number" step="0.01" name="effort" placeholder="e.g., 1.2" required>-->

        <button type="submit">Calculate</button>
        </form>

        <?php
        // Display the result if available
        if (isset($totalMonths) && isset($totalCostINR) && isset($functionalPoints)) {
            echo "<h2>Calculation Result</h2>";
            echo "<p>Total Months: " . round($totalMonths) . "</p>"; // Round to the nearest integer
            echo "<p>Total Cost: ₹" . number_format($totalCostINR, 2) . "</p>";
        }
        ?>
    </div>
</body>

</html>
