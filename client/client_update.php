<?php
session_start();
include('../conn.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    header('Location: client_dashboard.php');
    exit;
}

// Fetch user data from the database using the user's email
$sql = "SELECT cname, contact, username FROM client WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cname = $row['cname'];
    $contact = $row['contact'];
    $username = $row['username'];
} else {
    // Handle the case when the user's data is not found
    echo "User data not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update all the fields
    $newCName = $_POST['cname'];
    $newContact = $_POST['contact'];
    $newUsername = $_POST['username'];

    // Update the user's profile in the database
    $updateSql = "UPDATE client SET cname = '$newCName', contact = '$newContact', username = '$newUsername' WHERE email = '$email'";

    if ($conn->query($updateSql) === TRUE) {
        // Update successful
        $cname = $newCName; // Update the variable with the new name
        $contact = $newContact; // Update the variable with the new contact
        $username = $newUsername; // Update the variable with the new username
        echo '<script>alert("Profile updated successfully!");</script>'; // Display a success alert
        echo '<script>window.location.href = "client_dashboard.php?email=' . $email . '";</script>';
    } else {
        // Handle the case where the update query fails
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px 40px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .profile-container h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .profile-details {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .profile-details input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }
     

    </style>
</head>
<body>
<div class="container">
    <div class="profile-container">
        <h2>Edit Profile:</h2>
        <form method="POST">
            <div class="profile-details">
                <label for="cname">Name:</label>
                <input type="text" name="cname" value="<?php echo $cname; ?>" placeholder="New Name">
            </div>
            <div class="profile-details">
                <label for="contact">Contact:</label>
                <input type="text" name="contact" value="<?php echo $contact; ?>">
            </div>
            <div class="profile-details">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <!-- Add more fields as needed -->

            <div class="button-container">
                <button type="submit" class="edit-button">Save Changes</button>
                <a href="client_dashboard.php?email=<?php echo $email; ?>" style="float: right;">
                    <button class="edit-button" type="button">Back</button>
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
