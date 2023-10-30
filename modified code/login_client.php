<?php
session_start();
include('conn.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = md5($password);

    // Check if the user is a client
    $sql_client = "SELECT * FROM client WHERE email='$email' AND password='$hashed_password'";
    $result_client = $conn->query($sql_client);

    if (!$result_client) {
        die("SQL query failed: " . $conn->error);
    }

    if ($result_client->num_rows > 0) {
        // Client login successful
        echo "Client login successful.";
        header('Location: client/client_dashboard.php');
        exit();
    }

    // Check if the user is an admin statically
    if ($email === 'taskmasterhub2023@gmail.com' && $password === 'Admin@123') {
        // Admin login successful (statically)
        echo "Admin login successful.";
        header('Location: admin/dashboard.php');
        exit();
    }

    // If neither client nor admin, display an error message
    else {
        echo "<script>alert('Invalid username or password.'); window.location.href = 'login_client.php';</script>";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Login Page</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />
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
    height: 520px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
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
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 50px;
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
<a class="navbar-brand" href="../index.php">
            <img src="images/logo.png" alt="" />
            <span> TaskMasters Hub</span></a>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post">
        <h3>Login Here</h3>
       <label for="email">Email</label>
        <input type="text" placeholder="Enter Email" id="email" name="email" autocomplete="off">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" autocomplete="off">

        <button type="submit"id="submit" name="submit">Log In</button>
        <!-- <input type="button" value=""> -->
        <!-- <div class="social">
          <div class="go"><i class="fab fa-google"></i>  Google</div>
          <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div> -->
        <a href="client/register_client.php" >Create a account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="client/forgot_password.php" >Forgot Password</a><br><br>
    </form>
    <script>
        
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent the default form submission behavior
            
            // Get the email from the form
            const email = document.getElementById('email').value;

            // Redirect to the dashboard page with the username as a URL parameter
            window.location.href = `dashboard.php?email=${email}`;
        });
    </script>
</body>
</html>