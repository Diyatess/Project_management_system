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
    $desig_id = $_POST['desig_id']; // This should come from your form, e.g., a dropdown
    $hiredate = $_POST['hiredate'];
    $rid = '4';

    $selectedDesignation =  $_POST['desig_id']; 
    if ($selectedDesignation === "Designer") {
        $desi = "1";
    } elseif ($selectedDesignation === "Codder") {
        $desi = "2";
    } elseif ($selectedDesignation === "Tester") {
        $desi = "3";
    } 
    else {
        // Handle an invalid role selection or provide a default department
        $role = "Other";
    }

    // Generate a random unique MD5 password
    $random_password = md5(uniqid(rand(), true));

    // Insert data into the Employee table
    $sql = "INSERT INTO employee (fname, lname, gender, dob, email, contact, address, city, state, pincode, country, hiredate, password, desig_id)
            VALUES ('$fname', '$lname', '$gender', '$dob', '$email', '$contact', '$address', '$city', '$state', '$pincode', '$country', '$hiredate', '$random_password', '$desi')";
//echo $sql;
    if ($conn->query($sql) === TRUE) {
        // Insert data into the teammember table
        $employee_id = $conn->insert_id; // Get the ID of the newly inserted employee
        $role_id = 4; // Assuming role_id 4 represents a team member

        $teammember_sql = "INSERT INTO teammember (id, mid, task_id, rid) VALUES ($employee_id, NULL, NULL, $rid)";
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
        input[type="text"], input[type="email"], input[type="date"], input[type="number"] {
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
    </style>
</head>
<body>
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

            <label for="country">Country:</label>
            <input type="text" id="country" name="country">

            <label for="hiredate">Hire Date:</label>
            <input type="date" id="hiredate" name="hiredate" required>
            <label for="desig_id">Designation:</label>
            <select id="desig_id" name="desig_id" required>
                <option value="Designer">Designer</option>
                <option value="Coder">Coder</option>
                <option value="Tester">Tester</option>
            </select>

            <button type="submit">Add Employee</button>
        </form>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const fnameInput = document.getElementById('fname');
        const lnameInput = document.getElementById('lname');
        const emailValidation = document.getElementById('email-validation');
        const contactInput = document.getElementById('contact');
        const contactValidation = document.getElementById('contact-validation');

        emailInput.addEventListener('input', validateEmail);
        fnameInput.addEventListener('input', validateName);
        lnameInput.addEventListener('input', validatelName);
        contactInput.addEventListener('input', validateContact);

        function validateEmail() {
            const email = emailInput.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (!email.match(emailPattern)) {
                emailValidation.textContent = 'Please enter a valid email address.';
            } else {
                emailValidation.textContent = '';
            }
        }

        function validateContact() {
            const contact = contactInput.value;
            const indianContactPattern = /^\d{10}$/;

            if (!indianContactPattern.test(contact)) {
                contactValidation.textContent = 'Contact number must be 10 digits and follow the Indian format.';
            } else {
                contactValidation.textContent = '';
            }
        }

        function validateName() {
    const fname = fnameInput.value.trim();
    const fnameError = document.getElementById('fnameError');

    // Check for leading or trailing spaces
    if (fname !== fnameInput.value) {
        fnameError.textContent = 'Name cannot have leading or trailing spaces.';
    } else {
        const words = fname.split(' ');

        // Check if each part is at least 4 characters long, doesn't contain numbers, and doesn't exceed 20 characters
        const invalidPart = words.find(part => part.length < 1 || /\d/.test(part) || part.length > 20);

        if (fname === '') {
            fnameError.textContent = 'Please enter a name.';
        } else if (invalidPart) {
            fnameError.textContent = 'Each word must be at least 4 characters long, not contain numbers, and not exceed 20 characters.';
        } else {
            fnameError.textContent = '';
        }
    }
}

function validatelName() {
    const lname = lnameInput.value.trim();
    const lnameError = document.getElementById('lnameError');

    // Check for leading or trailing spaces
    if (lname !== lnameInput.value) {
        lnameError.textContent = 'Name cannot have leading or trailing spaces.';
    } else {
        const words = lname.split(' ');

        // Check if each part is at least 4 characters long, doesn't contain numbers, and doesn't exceed 20 characters
        const invalidPart = words.find(part => part.length < 1 || /\d/.test(part) || part.length > 20);

        if (lname === '') {
            lnameError.textContent = 'Please enter a name.';
        } else if (invalidPart) {
            lnameError.textContent = 'Each word must be at least 4 characters long, not contain numbers, and not exceed 20 characters.';
        } else {
            lnameError.textContent = '';
        }
    }
}
    </script>
</body>
</html>