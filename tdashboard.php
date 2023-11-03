<?php
session_start();
include('../conn.php'); 

// Fetch client requests and their associated client's contact from the database
$sql = "SELECT pr.request_id, pr.project_name, pr.project_description, pr.client_email, c.contact FROM project_requests pr 
JOIN client c ON pr.client_email = c.email WHERE pr.status = 'Pending';";
$result = $conn->query($sql);

$requests = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Lead Profile</title>
    <style>
   /* Style the sidebar */
   .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
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
/*main */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 24px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 32px;
            color: #fff;
            text-align: center; /* Center the heading text */
        }
        .profile-info {
            display: flex;
            align-items: center;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #0074D9;
            margin-right: 20px;
        }
        .profile-picture::before {
            content: "👤"; /* Display a user icon or your profile image */
            font-size: 50px;
            line-height: 100px;
            text-align: center;
            display: block;
        }
        .profile-details {
            color: #333;
        }
        .task-list {
            list-style: none;
            padding: 0;
        }
        .task-item {
            margin: 20px 0;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .task-item strong {
            color: #0074D9;
        }
        a {
            text-decoration: none;
            color: #0074D9;
        }
        a.navbar-brand {
            color: black;  /* Set the text color to black */
            text-decoration: none;  /* Remove the underline */
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

    </style>
</head>
<body>
<a class="navbar-brand" href="../index.php" style="float: left;">
            <img src="../images/logo.png" alt="" />
            <span> TaskMasters Hub</span>
        </a>
    <header>
        
        <h1>Team Lead page</h1>
    </header>
    <div class="container">
       


<!--client request-->
<h2>Client Requests</h2>
    <ul class="task-list">
        <?php if (empty($requests)) : ?>
            <li class="task-item">
                <strong>No new requests at the moment.</strong>
            </li>
        <?php else : ?>
            <?php foreach ($requests as $request) : ?>
                <li class="task-item">
                    <strong>Project Name:</strong> <?php echo $request['project_name']; ?><br>
                    <strong>Project Description:</strong> <?php echo $request['project_description']; ?><br>
                    <strong>Client Email:</strong> <?php echo $request['client_email']; ?><br>
                    <strong>Client Contact:</strong> <?php echo $request['contact']; ?><br>
                    <a href="message.php?request_id=<?php echo $request['request_id']; ?>">Reply</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
        <a href="edit_profile.php">
            <span class="icon">&#9998;</span> Edit Profile
        </a>
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
        <a href="add_project_details.php">
            <span class="icon">&#10010;</span> Add Project
        </a>
    </div>

    <div class="openbtn" onclick="toggleSidebar()">&#9776;</div>

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
</body>
</html>

