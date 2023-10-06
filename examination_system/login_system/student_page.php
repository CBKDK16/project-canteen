<?php

include 'config.php';

    $answers = [];
    $qAnswers = [];
    $sql = "SELECT eqt_id,ex_id,ex_answer FROM `examquestion_tbl`";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0)
    {
        while($rows = mysqli_fetch_assoc($result))
            array_push($answers,$rows);
    }
    // print_r($answers);

if (isset($_POST['btnExam'])) {

    $exam_id = $_POST['ex_id'];
    $user_id = $_POST['user_id'];
    $totalScore = 0;

    array_push($qAnswers,$_POST);
    print_r($qAnswers);
    
    foreach($qAnswers as $key => $qAnswer)
    {
        $question_count = $qAnswer['question_count'];
        $score = 100/$question_count;
        echo $score . '<br/>';
        echo $question_count;
        foreach($qAnswer as $keys => $value)
        {
            $id = $keys;
            $ans = $value;
            foreach($answers as $ids => $answer)
            {
                $eqt_id = $answer['eqt_id'];
                $ex_answer = $answer['ex_answer'];
                if($id == $eqt_id)
                {
                    if($value == $ex_answer)
                    {
                        $totalScore = $totalScore + $score;
                        
                    }
                }
            }
        }
    }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ensure $exam_id and $user_id are valid and not empty
    if (!empty($exam_id) && !empty($user_id)) 
    {
        // Check if the user has already taken the exam
        $check_query = $conn->prepare("SELECT user_id FROM exam_results WHERE ex_id = ? AND user_id = ?");
        $check_query->bind_param("ii", $exam_id, $user_id);
        $check_query->execute();
        $check_result = $check_query->get_result();

        if ($check_result->num_rows > 0) {
            echo "You have already taken this exam. You cannot take it again.";
            header('location:select_course.php?msg=2');

        } else {
            // Insert the results into the exam_results table
            $insert_query = $conn->prepare("INSERT INTO exam_results(ex_id, user_id, total_questions, score) VALUES (?, ?, ?, ?)");
            $insert_query->bind_param("iiii", $exam_id, $user_id, $question_count, $totalScore);

            if ($insert_query->execute()) {
                echo "Exam results stored successfully!";
                header('location:select_course.php?msg=3');
            } else {
                echo "Error: " . $conn->error;
            }

            $insert_query->close();
        }
    } else {
        echo "Invalid exam or user ID.";
    }

    $conn->close(); 
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        p {
            margin: 10px 0;
            color: #555;
        }

        .question {
            margin: 15px 0;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #timer {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
        }

        .question-options {
            display: flex;
            flex-direction: column;
        }

        .question-options label {
            margin: 5px 0;
        }

        .question-options input[type="radio"] {
            margin-right: 5px;
        }

        .result-button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .result-button:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <h1>Student Page</h1>
    <div class="container">
        <?php
        $qAnswer = [];
        $id = $_GET['id'];

        if (isset($_GET['course'])) {
            $selected_course = $_GET['course'];

            // Include your database configuration file (config.php)
            include 'config.php';

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve the exam associated with the selected course
            $exam_query = "SELECT ex_id, ex_title, ex_time_limit FROM examinfo_tbl WHERE course_name = '$selected_course'";
            $result = $conn->query($exam_query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $exam_id = $row['ex_id'];
                $exam_title = $row['ex_title'];
                $exam_time_limit = $row['ex_time_limit'];

                echo "<h2>Course : $selected_course</h2>";
                echo "<h2>Exam Title: $exam_title</h2>";
                echo "<p>Time Limit: <span id='timer'>$exam_time_limit:00</span> minutes</p>";

                // Retrieve questions for the selected exam
                $questions_query = "SELECT * FROM examquestion_tbl WHERE ex_id = $exam_id";
                $questions_result = $conn->query($questions_query);

                if ($questions_result->num_rows > 0) {
                    ?> 
                    <form method='post' action=''>
                        <input type="hidden" name="ex_id" value="<?php echo $exam_id ?>"/>
                        <input type="hidden" name="user_id" value="<?php echo $id ?>"/>
                    <?php
                    $i = 0;
                    while ($question_row = $questions_result->fetch_assoc()) {
                        $question_id = $question_row['eqt_id'];
                        $score = $question_row['score'];
                        $question_text = $question_row['ex_question'];
                        $choices = array(
                            $question_row['ex_ch1'],
                            $question_row['ex_ch2'],
                            $question_row['ex_ch3'],
                            $question_row['ex_ch4']
                        );

                        echo "<p class='question'>$question_text</p>";
                        foreach ($choices as $choice) {?>
                            <input type='radio' name='<?php echo $question_id ?>' value='<?php echo $choice?>' id='choice_$i'/><?php echo $choice ?> <br>
                                
                            <?php 
                        }
                        $i++;
                    }
                    ?>
                    <input type="hidden" name="score" value="<?php echo $score ?>"/>
                    <input type='hidden' name='question_count' value='<?php echo $i; ?>'>
                    <input type='submit' value='Submit Exam' name="btnExam">
                    <a href="select_course.php" onclick="return confirm('Are you sure you want to exit this Exam. If you exit this exam then we wont able to take this exam again.?')">Cancel</a>
                    </form>
                    <?php
                } else {
                    echo "No questions found for this exam.";
                }
            } else {
                echo "No exam found for the selected course.";
            }

            $conn->close(); // Close the database connection

        } else {
            echo "Please select a course from the previous page.";
        }
        ?>
    </div>

    <script>
        // JavaScript for countdown timer
        var timeLimit = <?php echo $exam_time_limit; ?> * 60; // Set the time limit in seconds
        var timer = document.getElementById("timer");

        function updateTimer() {
            var minutes = Math.floor(timeLimit / 60);
            var seconds = timeLimit % 60;
            timer.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

            if (timeLimit > 0) {
                timeLimit--;
            } else {
                // Redirect to the submission page when time is up
                window.location.href = "select_course.php?msg=1";
            }
        }

        // Update the timer every second
        setInterval(updateTimer, 1000);
    </script>
</body>
</html>
