<?php
session_start();
include('../conn.php');

// Fetch approved and denied projects
$sql = "SELECT project_requests.project_name, project_requests.project_description, 
project_requests.client_email AS project_client_email, project_requests.status AS project_status, 
client.cname AS client_name, client.email AS client_email FROM project_requests JOIN client ON project_requests.client_email = client.email 
WHERE project_requests.status IN ('Approved', 'Denied')";

$result = $conn->query($sql);

$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Approved/Denied Projects</title>
    <style>
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
            text-align: center;
        }
        .project-list {
            list-style: none;
            padding: 0;
        }
        .project-item {
            margin: 20px 0;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .project-item strong {
            color: #0074D9;
        }
        a {
            text-decoration: none;
            color: #0074D9;
        }
        a.navbar-brand {
            color: black;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            font-size: 24px;
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
    <span>TaskMasters Hub</span>
</a>
<a class="navbar-brand" href="tdashboard.php" style="float: right;">
    <span>Back</span>
</a>
<header>
    <h1>View Approved/Denied Projects</h1>
  
</header>
<div class="container">
    <h2>Approved/Denied Projects</h2>
    <ul class="project-list">
        <?php foreach ($projects as $project) : ?>
            <li class="project-item">
                <strong>Project Name:</strong> <?php echo $project['project_name']; ?><br>
                <strong>Project Description:</strong> <?php echo $project['project_description']; ?><br>
                <strong>Project Status:</strong> <?php echo $project['project_status']; ?><br>
                <strong>Client Name:</strong> <?php echo $project['client_name']; ?><br>
                <strong>Client Email:</strong> <?php echo $project['client_email']; ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
