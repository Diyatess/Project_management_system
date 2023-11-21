

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="s.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <title>Admin Panel</title>
    <style>
        /* Reset some default styles */
body, h1, ul, li, a {
    margin: 0;
    padding: 0;
    list-style: none;
    text-decoration: none;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Admin Panel Container */
.admin-panel {
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    flex-wrap: wrap; /* Allow content to wrap to the next line */
}

/* Header Styles */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #120c43;
    padding: 10px 0; /* Adjust padding */
    box-shadow: 1px 5px 5px rgba(0, 0, 0, 0.51);
    width: 100%; /* Set the width to 100% */
}

.user-profile img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
}

.logout-btn {
    background-color: #000000;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.logout-btn:hover {
    background-color: #0e0d0d;
}


/* Main Content Styles */
.main-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    background-color: #bebcd0b9;
}

/* Content Area Styles */
.content {
    padding: 20px;
    overflow: auto;
}

.slider {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(19, 16, 16, 0.1);
    border-radius: 5px;
}

    </style>
</head>
<body>
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

<div class="admin-panel">
    <!-- Header -->
    <header class="header">
                <div class="user-profile"></div>
                <a class="navbar-brand" href="../index.php">
                    <img src="../images/logo.png" alt="" />
                    <span>TaskMasters Hub</span>
                </a>
                <button onclick="logout()" type="button">Logout</button>
            </header>
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">Admin Panel</div>
            <ul class="menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="adduser.php">Add Employee</a></li>
                <li><a href="dashboard.php">View Task</a></li>
                <li><a href="user_fetch.php">Client</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            

            <!-- Content Area -->
            <div class="content">
                <!-- Your content goes here -->
                <h1>Welcome to the Admin Panel</h1>
            </div>
        </main>
    </div>
</body>
</html>
