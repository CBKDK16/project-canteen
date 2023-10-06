<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
    
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header {
    background-color: #007BFF;
    color: #fff;
    text-align: center;
    padding: 10px;
}

h1 {
    font-size: 24px;
    margin: 10px 0;
}
a{
   background: crimson;
   color:#fff;
   border-radius: 5px;
   padding:0 15px;
}

h2 {
    font-size: 20px;
    color: #007BFF;
    margin: 20px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #007BFF;
    color: #fff;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.add-button {
    margin-top: 10px;
}

.add-button a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-right: 10px;
}

.add-button a:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <header>
        <h1>Teacher Panel</h1>
        <a href="logout.php">Logout</a>
    </header>
    <div class="container">
        <h2>Manage Exams</h2>
       <table>
        <tr>
            <th>Exam Name</th>
            <th>Actions</th>
        </tr>

       <?php
        @include 'config.php';

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    
        $sql = "SELECT ex_id, course_name, ex_title FROM examinfo_tbl";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td><a href='delete_exam.php?ex_id=" . $row["ex_id"] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No exams found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
        <div class="add-button">
            <a href="update_questions.php">Add Exam</a>
        </div>

        <div class="add-button">
            <a href="view_question.php">View Question</a>
        </div>

        <div class="add-button">
            <a href="publish_result.php">Publish Result</a>
        </div>
    </div>
</body>
</html>
