
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet" />
    <link href="s.css" rel="stylesheet" />
    <title>User Fetch Page</title>
    <style>
    body {
    font-family: Arial, sans-serif;
}

.content {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 12px;
    text-align: left;
}


th {
    background-color: #f5f5f5;
}
   </style>
</head>
<body>
    <div class="content">
        <h2>User List</h2>
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Contact</th>
                <th>email</th>
                <!--<th>Action</th>-->
                
            </tr>

            <?php
            // Include database connection code
            include('../conn.php');

            // SQL query to fetch all users
            $sql = "SELECT * FROM client";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["cname"] . "</td>";
                    echo "<td>" . $row["contact"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                   /* echo "<td>
                            <a href='edit_user.php?id=" . $row["id"] . "'>Edit</a>
                            <a href='delete_user.php?id=" . $row["id"] . "'>Delete</a>
                          </td>";
                    echo "</tr>";*/
                }
            } else {
                echo "<tr><td colspan='3'>No users found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
                <a href="dashboard.php">Dashboard</a>
    </div>
</body>
</html>


