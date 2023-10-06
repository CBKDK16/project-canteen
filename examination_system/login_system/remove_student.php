<?php
@include 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_student"])) {
    $studentId = $_POST["student_id"];
    
    $deleteSql = "DELETE FROM user_form WHERE id = $studentId";
    
    if ($conn->query($deleteSql) === TRUE) {
        echo "Student with ID $studentId has been removed successfully.";
    } else {
        echo "Error removing student: " . $conn->error;
    }
}

$sql = "SELECT * FROM user_form ORDER BY user_type";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove User</title>

       <link rel="stylesheet" href="css/remove_student.css">
      
    <style>
      
    </style>
</head>
<body>
    <h1>Remove User</h1>
    <a href="admin_page.php">Admin Panel</a>
    <div>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>User Type</th><th>Delete</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["user_type"] . "</td>";
                echo "<td>
                      <form method='post'>
                        <input type='hidden' name='student_id' value='" . $row["id"] . "'>
                        <input type='submit' name='delete_student' value='Delete'>
                      </form>
                    </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No students found.";
        }
        ?>
    </div>
</body>
</html>
