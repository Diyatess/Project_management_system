<?php
session_start();
include('../conn.php'); 

// Fetch client requests from the database
$sql = "SELECT request_id, project_name, project_description, client_email FROM project_requests WHERE status = 'Pending'";
$result = $conn->query($sql);

$requests = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}


// Simulated data (Replace with your team lead's information)
$teamLead = [
    'name' => 'John Doe',
    'title' => 'Team Lead',
    'email' => 'johndoe@gmail.com',
    'phone' => '+91 7442 896 230',
    /*'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in justo ac est varius viverra ut eu mi. Morbi sodales odio a odio venenatis.',*/
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Lead Profile</title>
    <style>
 /* Style the action list */
.action-list {
    list-style: none;
    padding: 0;
}

/* Style the individual action items */
.action-list li {
    margin: 10px 0;
}

/* Style the action links */
.action-link {
    text-decoration: none;
    color: #fff;
    background: linear-gradient(135deg, #0074D9, #00D2FC);
    border: 2px solid #0074D9;
    border-radius: 30px;
    padding: 10px 15px;
    display: inline-block;
    transition: all 0.3s;
    font-weight: bold;
    font-size: 16px;
}

/* Hover effect */
.action-link:hover {
    background: linear-gradient(135deg, #00D2FC, #0074D9);
    color: #fff;
    transform: scale(1.05);
}
/* Style the action icons */
.action-icon {
    margin-right: 10px;
    font-size: 20px;
}


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
        }
        img {
            width: 39px;
            height: 39px;
        }
    //*contact info */
    .contact-info {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 10px;
    margin-top: 10px;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.contact-label {
    width: 80px;
    font-weight: bold;
}

.contact-value {
    flex: 1;
}

    </style>
</head>
<body>
<a class="navbar-brand" href="../index.php" style="float: left;">
            <img src="../images/logo.png" alt="" />
            <span> TaskMasters Hub</span>
        </a>
    <header>
        
        <h1>Team Lead Profile</h1>
    </header>
    <div class="container">
        <div class="profile-info">
            <div class="profile-picture"></div>
            <div class="profile-details">
                <h2><?php echo $teamLead['name']; ?></h2>
                <p><?php echo $teamLead['title']; ?></p>
            </div>
        </div>
        <!--<h2>About Me</h2>
        <p><?php echo $teamLead['bio']; ?></p>-->
        <h2>Contact Information</h2>
<div class="contact-info">
    <div class="contact-item">
        <span class="contact-label">Email:</span>
        <span class="contact-value"><?php echo $teamLead['email']; ?></span>
    </div>
    <div class="contact-item">
        <span class="contact-label">Phone:</span>
        <span class="contact-value"><?php echo $teamLead['phone']; ?></span>
    </div>
</div>

   <!--Actions-->     
        <h2>Actions</h2>
<div class="action-list">
        <a href="edit_profile.php" class="action-link">
            <span class="action-icon">&#9998;</span> Edit Profile
        </a>&nbsp;&nbsp;
        <a href="add_task.php" class="action-link">
            <span class="action-icon">&#10010;</span> Add Task
        </a>&nbsp;&nbsp;
    
        <a href="view_status.php" class="action-link">
            <span class="action-icon">&#128196;</span> View Status
        </a>&nbsp;&nbsp;
        <a href="schedule_meeting.php" class="action-link">
            <span class="action-icon">&#9201;</span> Schedule Meeting
        </a>&nbsp;&nbsp;<br><br>
    
        <a href="monitor_progress.php" class="action-link">
            <span class="action-icon">&#128221;</span> Monitor Daily Progress
        </a>&nbsp;&nbsp;
   
        <a href="view_projects.php" class="action-link">
            <span class="action-icon">&#128213;</span> View Approved/Denied Projects
        </a>&nbsp;&nbsp;
    </div>

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

                <?php if (array_key_exists('request_id', $request)) : ?>
                    <!-- Accept and Deny Buttons -->
                    <a href="accept_request.php?request_id=<?php echo $request['request_id']; ?>">Accept</a>
                    <a href="deny_request.php?request_id=<?php echo $request['request_id']; ?>">Deny</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>


    </div>
</body>
</html>

