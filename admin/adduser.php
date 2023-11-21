<?php
// Include your database connection code here
include('../conn.php');
// Initialize the designation options array
$designationOptions = [];

// Fetch data from the designation table
$designationQuery = "SELECT desig_id, desig_type FROM designation";
$result = $conn->query($designationQuery);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $designationOptions[$row['desig_id']] = $row['desig_type'];
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Function to send a welcome email
function sendWelcomeEmail($recipientEmail, $recipientName, $verifyToken, $userEmail, $userPassword) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Update with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'taskmasterhub2023@gmail.com'; // Update with your email
        $mail->Password = 'tgzpeyjxxpjafund'; // Update with your email password
        $mail->SMTPSecure = 'tls'; // Use TLS
        $mail->Port = 587; // Port for TLS

        // Recipients
        $mail->setFrom('taskmasterhub2023@gmail.com', 'TaskMaster Hub'); // Update with your email and name
        $mail->addAddress($recipientEmail, $recipientName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Website';
        $mail->Body = 'Hello ' . $recipientName . ',<br>Welcome to our Company!<br>Your login credentials are as follows:<br>' .
            '<strong>Email:</strong> ' . $userEmail . '<br>' .
            '<strong>Password:</strong> ' . $userPassword . '<br>' .
            'Click here to login <a href="http://localhost/Taskmaster/admin/verify.php?token=' . urlencode($verifyToken) . '">Click here to verify your email</a>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log or handle the exception appropriately
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $country = $_POST['country'];
    $desig_id = $_POST['desig_id']; 
    $hiredate = $_POST['hiredate'];
    $password = $_POST['password'];
    $rid = '4';

    // Generate a verification token (you can use any method you prefer)
    $verifyToken = md5(uniqid(rand(), true));

    $selectedDesignation =  $_POST['desig_id']; 

    if ($selectedDesignation === "Designer") {
        $desi = "1";
    } elseif ($selectedDesignation === "Codder") {
        $desi = "2";
    } elseif ($selectedDesignation === "Tester") {
        $desi = "3";
    } else {
        // Handle an invalid role selection or provide a default department
        $desi = "Default"; // You can change this to the appropriate default value
    }
    

    // Generate a random unique MD5 password
    $hpassword = md5($password);

    // Insert data into the Employee table
    $sql = "INSERT INTO employee (fname, lname, gender, dob, email, contact, address, city, state, pincode, country, hiredate, password, desig_id,verify_token)
            VALUES ('$fname', '$lname', '$gender', '$dob', '$email', '$contact', '$address', '$city', '$state', '$pincode', '$country', '$hiredate', '$hpassword', '$desi','$verifyToken')";
//echo $sql;
    if ($conn->query($sql) === TRUE) {
        // Insert data into the teammember table
        $employee_id = $conn->insert_id; // Get the ID of the newly inserted employee
        $role_id = 4; // entering id as 4 in db

        if (sendWelcomeEmail($email, $fname . " " . $lname, $verifyToken, $email, $password)) {
            // Registration successful. Welcome email sent!
            $_SESSION['status'] = 'Registration successful. Welcome email sent!';
        } else {
            // Registration successful, but there was an issue sending the welcome email.
            $_SESSION['status'] = 'Registration successful, but there was an issue sending the welcome email.';
        }

        $teammember_sql = "INSERT INTO teammember (emp_id,task_id, rid) VALUES ($employee_id,  NULL, $rid)";
        if ($conn->query($teammember_sql) === TRUE) {
            echo '<script>alert("Employee data added successfully.");</script>';
            echo '<script>window.location.href = "dashboard.php";</script>';
        } else {
            echo "Error: " . $teammember_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link href="../css/style.css" rel="stylesheet" />
    
    <style>
        /*for header and slider*/
        .slider {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(19, 16, 16, 0.1);
    border-radius: 5px;
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
* Sidebar Styles */
.sidebar {
    width: 200px;
    background-color: #6a6666;
    color: #fff;
    padding: 20px;
    height: 167%;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.menu li {
    margin-bottom: 10px;
}

.menu a {
    color: #ffffff;
    display: block;
    padding: 5px 0;
}

.menu a:hover {
    background-color: #555;
    border-radius: 5px;
}
/*end*/
        body {
            font-family: Arial, sans-serif;
            background-color: #14182f;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        label, input, select {
            display: block;
            margin: 10px 0;
        }
        input[type="text"], input[type="email"], input[type="date"], input[type="number"],input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #008cba;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
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
    </style>
</head>
<body><a href="dashboard.php" class="back-button" style="float: right;">Back</a>
<a class="navbar-brand" href="../index.php">
        <img src="../images/logo.png" alt="" />
        <span> TaskMasters Hub</span>
    </a>
    <div class="container">
        <h1>Add Employee</h1>
        <form method="POST" action="" onsubmit="return validateForm()">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>
            <div id="fnameError" style="color: red;"></div>

            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>
            <div id="lnameError" style="color: red;"></div>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            <span id="dob-validation" style="color: red;"></span>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <div id="email-validation" style="color: red;"></div>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>
            <div id="contact-validation" style="color: red;"></div>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address">

            <label for="city">City:</label>
            <input type="text" id="city" name ="city">

            <label for="state">State:</label>
            <input type="text" id="state" name="state">

            <label for="pincode">Pincode:</label>
            <input type="text" id="pincode" name="pincode">
            <div id="pincode-validation" style="color: red;"></div>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country">

            <label for="hiredate">Hire Date:</label>
            <input type="date" id="hiredate" name="hiredate" required>
            <span id="hiredate-validation"  style="color: red;"></span>

            <label for="desig_id">Designation:</label>
            <select id="desig_id" name="desig_id" required>
                <option value="Designer">Designer</option>
                <option value="Codder">Coder</option>
                <option value="Tester">Tester</option>
            </select>
            <label for="password"> Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Add Employee</button>
            
        </form>
    </div>
    <script src="validate.js"></script>
</body>
</html>