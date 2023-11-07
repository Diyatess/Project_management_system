<?php
session_start();
include('../conn.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    echo "Email not provided in the URL.";
}

// Ensure you have a valid email address before proceeding


mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="st.css"> <!-- Link an external CSS file for better organization -->
       
    <script>
    // Logout function
    function logout() {
            // Clear the session or perform any other necessary logout tasks
            // Disable the ability to go back
            history.pushState(null, null, window.location.href);
            window.onpopstate = function (event) {
                history.go(1);
            };

            // Redirect to the login page
            window.location.replace("../login_client.php");
        }

    // Disable caching to prevent back button from showing the logged-in page
    window.onload = function () {
        window.history.forward();
        document.onkeydown = function (e) {
            if (e.keyCode === 9) {
                return false;
            }
        };
    }

    // Redirect to the login page if the user tries to go back
    window.addEventListener('popstate', function (event) {
        window.location.replace("../login_client.php");
    });
</script>

    <style>
    .red-dot {
    position: relative;
    text-decoration: none; /* Remove the underline */
    color: #007BFF; /* Link text color */
}

.red-dot::before {
    content: '\2022'; /* Unicode character for a bullet (•) */
    position: absolute;
    top: -5px; /* Adjust the vertical position of the dot */
    left: 0;
    color: red; /* Red color for the dot */
}

.red-dot:hover {
    text-decoration: underline; /* Underline on hover */
    color: #0056b3; /* Change link text color on hover */
}

    </style>
</head>

<body>
    <a class="navbar-brand" href="../index.php">
        <img src="../images/logo.png" alt="" />
        <span> TaskMasters Hub</span>
    </a>
    <div id="container">
        <div id="sidebar">
            <h3>Dashboard Menu</h3>
            <ul>
                <li><a href="client_dashboard.php">Project Progress</a></li>
                <li><a href="sugg.html">Suggestions/Add-ons</a></li>
                <li><a href="client_update.php?email=<?php echo $email; ?>">Update Profile</a></li>
                <li><a href="add_project.php?email=<?php echo $email; ?>">Add project</a></li>
            </ul>
            <!-- Logout button -->
            <button onclick="logout()" type="button">Logout</button>
        </div>
        <div id="content">
            <h2>Welcome to Your Dashboard <?php echo $email; ?>!</h2>
            <p>This is your client dashboard. You can view your project progress, provide suggestions, make payments, and update your profile here.</p>

            <h3>Project Progress</h3>
            <p>Project progress: XX%</p>
            <div class="message-container" id="messageContainer">
            <a href="view_proposal.php?email=<?php echo $email; ?>" class="red-dot">View proposal</a>
            <p><a href="view_messages.php?email=<?php echo $email; ?>" class="red-dot">View Message</a></p>
</div>

        </div>
    </div>
</body>

</html>
