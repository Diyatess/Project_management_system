<?php
session_start();

include('../conn.php');

// Extract request_id from the URL
if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            color: #fff;
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
        
    </style>
</head>
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
 window.onload = function () {
        window.history.forward();
        document.onkeydown = function (e) {
            if (e.keyCode === 9) {
                return false;
            }
        };
    }
    </script>
<body>
    <header>
        <a href="tdashboard.php" class="back-button" style="float: right;">Back</a>
        <h1>Create a Software Project Proposal Draft</h1>
    </header>
    <!-- Sidebar -->
<div id="mySidebar" class="sidebar">
<a href="tdashboard.php">
            <span class="dashboard-icon">📊</span> Dashboard
        </a>
        <!-- <a href="edit_profile.php">
            <span class="icon">&#9998;</span> Edit Profile
        </a>-->
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
       
    </div>

    <div class="openbtn" onclick="toggleSidebar()">&#9776;</div>

    <div class="container">

        <form method="post"  action="generate-proposal.php">
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

