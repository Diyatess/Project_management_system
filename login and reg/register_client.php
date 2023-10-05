<?php
include('conn.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $cname = $_POST['cname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform basic server-side validation
    if (empty($username) || empty($cname) || empty($contact) || empty($email) || empty($password)) {
        echo "Please fill out all the fields.";
    } else if (!preg_match("/^\d{10}$/", $contact)) {
        echo "Contact number must be exactly 10 digits.";
    } else {
        // Hash the password using MD5 (not recommended for production)
        $hashed_password = md5($password);

        // SQL query to insert user into the database
        $sql = "INSERT INTO client (username, cname, contact, email, password )
                VALUES ('$username', '$cname', '$contact', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully!";
            header('Location: login_client.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Signup Page</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #1a2e35;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #826d19,
        #55104ceb
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    
    right: -30px;
    bottom: -80px;
}
form{
    height: 630px;
    width: 450px;
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 40px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 2px;
    font-size: 14px;
    font-weight: 300;
}
#role{
    display: block;
    height: 40px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 2px;
    font-size: 14px;
    font-weight: 300;
}
option{
    display: block;
    height: 40px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 2px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 14px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.social{
  margin-top: 30px;
  display: flex;
}
.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
}
.social div:hover{
  background-color: rgba(255,255,255,0.47);
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}

    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
        <a href="index.html" >Index Page</a>
    </div>
    <form action="" method="POST" onsubmit="return validateForm()">
       
            <h3>Signup Here</h3>
    
            <label for="username">Username</label>
            <input type="text" placeholder="Username" name="username" id="username"autocomplete="off">

            <label for="cname">Name</label>
            <input type="text" placeholder="Name" name="cname" id="cname"autocomplete="off">

            <label for="contact">Contact</label>
            <input type="text" placeholder="Contact" name="contact" id="contact"autocomplete="off">


            <label for="email">Email</label>
            <input type="email" placeholder="Email" name="email" id="email"autocomplete="off">

            <label for="password1">Password</label>
            <input type="password" placeholder="Password" id="password" name="password"autocomplete="off">

            <button type="submit">Signup</button>
            <a href="login_client.php" >I already have an account</a>
            <br><br>
            <a href="index.html" >Index Page</a>
        </form>
        <script>
        function validateForm() {
            const password = document.getElementById('password').value;

            // Check password length
            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }

            // Check if password contains a number
            if (!/\d/.test(password)) {
                alert('Password must contain at least one number.');
                return false;
            }

            // Check if password contains a special character
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                alert('Password must contain at least one special character.');
                return false;
            }

            // Check if password contains an uppercase letter
            if (!/[A-Z]/.test(password)) {
                alert('Password must contain at least one uppercase letter.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
