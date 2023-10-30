<?php
// Simulated data (Replace with your database connection and queries)
$teamLead = [
    'name' => 'John Doe',
    'title' => 'Team Lead',
    'email' => 'john.doe@example.com',
    'phone' => '(123) 456-7890',
    'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in justo ac est varius viverra ut eu mi. Morbi sodales odio a odio venenatis.',
];

// Simulated tasks (Replace with actual tasks and data)
$tasks = [
    ['id' => 1, 'title' => 'Task 1', 'description' => 'Description for Task 1'],
    ['id' => 2, 'title' => 'Task 2', 'description' => 'Description for Task 2'],
    ['id' => 3, 'title' => 'Task 3', 'description' => 'Description for Task 3'],
    // Add more tasks as needed
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Lead Profile</title>
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
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            font-size: 24px;
        }
        .profile-info {
            display: flex;
            align-items: center;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
            margin-right: 20px;
        }
        .task-list {
            list-style: none;
            padding: 0;
        }
        .task-item {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #0074D9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Team Lead Profile</h1>
    </header>
    <div class="container">
        <div class="profile-info">
            <div class="profile-picture"></div>
            <div>
                <h2><?php echo $teamLead['name']; ?></h2>
                <p><?php echo $teamLead['title']; ?></p>
            </div>
        </div>
        <h3>About Me</h3>
        <p><?php echo $teamLead['bio']; ?></p>
        <h3>Contact Information</h3>
        <ul>
            <li>Email: <?php echo $teamLead['email']; ?></li>
            <li>Phone: <?php echo $teamLead['phone']; ?></li>
        </ul>
        <h3>Task Division</h3>
        <ul class="task-list">
            <?php foreach ($tasks as $task) : ?>
                <li class="task-item">
                    <a href="task_details.php?id=<?php echo $task['id']; ?>">
                        <?php echo $task['title']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
