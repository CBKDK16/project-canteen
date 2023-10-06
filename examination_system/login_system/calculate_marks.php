<?php
  @include 'config.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the student's answers and the correct answers
$exam_id = $_POST['exam_id'];
$total_marks = $_POST['total_marks'];

$student_answers = $_POST['answer'];
$correct_answers = [];

$sql = "SELECT eqt_id, ex_answer FROM examquestion_tbl WHERE ex_id = $exam_id";
$answer_result = $conn->query($sql);

while ($row = $answer_result->fetch_assoc()) {
    $correct_answers[$row['eqt_id']] = $row['ex_answer'];
}

// Calculate the marks
$marks = 0;
foreach ($student_answers as $eqt_id => $student_answer) {
    if (isset($correct_answers[$eqt_id]) && $student_answer === $correct_answers[$eqt_id]) {
        $marks++;
    }
}

// Display the marks
echo "You scored $marks out of $total_marks.";

// You can save the marks and other information to your database if needed.

// Close the database connection
$conn->close();
?>
