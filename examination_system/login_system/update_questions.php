<?php

$courseName = $examTitle = $timeLimit = $questions = $choices = $correctAnswers = $scores = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data

    $courseName = $_POST["course_name"];
    $examTitle = $_POST["ex_title"];
    $timeLimit = $_POST["ex_time_limit"];
    $questions = $_POST["questions"];
    $choices = $_POST["choices"];
    $correctAnswers = $_POST["correct_answer"];

    
   @include 'config.php';
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert exam information into `examinfo_tbl`
    $insertExamInfoSQL = "INSERT INTO examinfo_tbl (course_name, ex_title, ex_time_limit) VALUES ('$courseName', '$examTitle', $timeLimit)";
    if ($conn->query($insertExamInfoSQL) === TRUE) {
        $examID = $conn->insert_id; // Get the last inserted exam ID
    } else {
        echo "Error inserting exam info: " . $conn->error;
    }

    // Insert questions into `examquestion_tbl`
    if (!empty($examID)) {
        foreach ($questions as $key => $question) {
            $questionText = $question;
            $choice1 = $choices[0][$key];
            $choice2 = $choices[1][$key];
            $choice3 = $choices[2][$key];
            $choice4 = $choices[3][$key];
            $correctAnswer = $correctAnswers[$key];

            $insertQuestionSQL = "INSERT INTO examquestion_tbl (ex_id, ex_question, ex_ch1, ex_ch2, ex_ch3, ex_ch4, ex_answer,score) VALUES ($examID, '$questionText', '$choice1', '$choice2', '$choice3', '$choice4', '$correctAnswer',5)";
             

            if ($conn->query($insertQuestionSQL) !== TRUE) {
                echo "Error inserting question: " . $conn->error;
            }
        }
    }
    else
    {
        echo 'Error inserting question';
    }
    header('Location: view_question.php');
    
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Exam Question</title>

   <link rel="stylesheet" href="css/updatequestion.css">

</head>
<body>
    <header>
        <h1>
            <a href="admin_page.php">Admin Panel</a>
        </h1>
    </header>
    <h2>Update Exam Questions</h2>
    <form action="update_questions.php" method="post">
        <label for="course_name">Subject:</label>
        <input type="text" name="course_name" required><br><br>
        
        <label for="ex_title">Exam Title:</label>
        <input type="text" name="ex_title" required><br><br>
        
        <label for="ex_time_limit">Time Limit (in minutes):</label>
        <input type="number" name="ex_time_limit" required><br><br>
        
        <h3>Questions:</h3>
        <div id="questions">
            <div class="question">
                <label for="questions[]">Question:</label>
                <input type="text" name="questions[]" required>
                <br>
                
                <label for="choices[]">Choices:</label><br>
                <input type="text" name="choices[0][]" placeholder="Choice 1" required>
                <input type="text" name="choices[1][]" placeholder="Choice 2" required>
                <input type="text" name="choices[2][]" placeholder="Choice 3" required>
                <input type="text" name="choices[3][]" placeholder="Choice 4" required>
                <br>
                
                <label for="correct_answer[]">Correct Answer:</label>
                <input type="text" name="correct_answer[]" required>

                <label for="score[]">Score: 5</label>
            </div>
        </div>
        
        <button type="button" id="addQuestion">Add Question</button>
        <br><br>
        <input type="submit" value="Update Questions">
    </form>

    <script>
        // JavaScript to add new question fields
        let questionCount = 1;
        const addQuestionButton = document.getElementById('addQuestion');
        const questionsDiv = document.getElementById('questions');

        addQuestionButton.addEventListener('click', function () {
            questionCount++;
            const newQuestionDiv = document.createElement('div');
            newQuestionDiv.classList.add('question');
            newQuestionDiv.innerHTML = `
                <label for="questions[]">Question:</label>
                <input type="text" name="questions[]" required>
                <br>
                
                <label for="choices[]">Choices:</label><br>
                <input type="text" name="choices[0][]" placeholder="Choice 1" required>
                <input type="text" name="choices[1][]" placeholder="Choice 2" required>
                <input type="text" name="choices[2][]" placeholder="Choice 3" required>
                <input type="text" name="choices[3][]" placeholder="Choice 4" required>
                <br>
                
                <label for="correct_answer[]">Correct Answer</label>
                <input type="text" name="correct_answer[]" required>

                <label for="score[]">Score: 5</label>
            `;
            questionsDiv.appendChild(newQuestionDiv);
        });
    </script>
</body>
</html>
