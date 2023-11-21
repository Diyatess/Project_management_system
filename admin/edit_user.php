<?php
// Include the database connection file
require_once("../conn.php");

// Get id from URL parameter
$username = $_GET['username'];

// Select data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM client WHERE username = $username");

// Fetch the next row of a result set as an associative array
$resultData = mysqli_fetch_assoc($result);

$username = $resultData['username'];
$cname = $resultData['cname'];
$contact = $resultData['contact'];
$email = $resultData['email'];
$projectname = $resultData['projectname'];
$description = $resultData['description'];
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
    <h2>Edit Data</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" >
		<table border="0">
			<tr> 
				<td>Username</td>
				<td><input type="text" name="username" value="<?php echo $username; ?>"></td>
			</tr>
			<tr> 
				<td>Name</td>
				<td><input type="text" name="cname" value="<?php echo $cname; ?>"></td>
			</tr>
            tr> 
				<td>contact</td>
				<td><input type="text" name="contact" value="<?php echo $contact; ?>"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email" value="<?php echo $email; ?>"></td>
			</tr>
            tr> 
				<td>projectname</td>
				<td><input type="text" name="projectname" value="<?php echo $projectname; ?>"></td>
			</tr>
            tr> 
				<td>description</td>
				<td><input type="text" name="description" value="<?php echo $description; ?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $username; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
