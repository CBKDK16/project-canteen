<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questions</title>
    <link rel="stylesheet" href="css/view_question.css">
</head>
<body>
        <h1>
            <a href="admin_page.php">Admin Panel</a>
        </h1>
    
    <h2>View Questions</h2>


<?php
@include 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_question'])) {
    $question_id = $_POST['question_id'];

    $delete_query = "DELETE FROM examquestion_tbl WHERE eqt_id = $question_id";

    if ($conn->query($delete_query) === TRUE) {
        echo "Question deleted successfully.";
    } else {
        echo "Error deleting question: " . $conn->error;
    }
}
$sql = "SELECT eqt.ex_question, eqt.ex_ch1, eqt.ex_ch2, eqt.ex_ch3, eqt.ex_ch4, eqt.ex_answer, ei.course_name, eqt.eqt_id 
        FROM examquestion_tbl eqt
        INNER JOIN examinfo_tbl ei ON eqt.ex_id = ei.ex_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Course Name</th><th>Question</th><th>Choice 1</th><th>Choice 2</th><th>Choice 3</th><th>Choice 4</th><th>Answer</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["course_name"] . "</td>";
        echo "<td>" . $row["ex_question"] . "</td>";
        echo "<td>" . $row["ex_ch1"] . "</td>";
        echo "<td>" . $row["ex_ch2"] . "</td>";
        echo "<td>" . $row["ex_ch3"] . "</td>";
        echo "<td>" . $row["ex_ch4"] . "</td>";
        echo "<td>" . $row["ex_answer"] . "</td>";
        echo '<td><form method="post"><input type="hidden" name="question_id" value="' . $row["eqt_id"] . '"><input type="submit" name="delete_question" value="Delete"></form></td>';
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No questions found.";
}

$conn->close();
?>

</body>
</html>
