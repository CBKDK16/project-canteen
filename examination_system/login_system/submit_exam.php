<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the correct answers for each question
    $correctAnswers = array("2", "1", "4", "3", "1");

    
    $totalScore = 0;

    include 'config.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $user_id = $_GET['id'];
    $exam_id = $_GET['examid'];

    // Ensure $exam_id and $user_id are valid and not empty
    if (!empty($exam_id) && !empty($user_id)) {
        // Check if the user has already taken the exam
        $check_query = $conn->prepare("SELECT user_id FROM exam_results WHERE ex_id = ? AND user_id = ?");
        $check_query->bind_param("ii", $exam_id, $user_id);
        $check_query->execute();
        $check_result = $check_query->get_result();

        if ($check_result->num_rows > 0) {
            echo "You have already taken this exam. You cannot take it again.";
        } else {
            // Insert the results into the exam_results table
            $insert_query = $conn->prepare("INSERT INTO exam_results(ex_id, user_id, score) VALUES (?, ?, ?)");
            $insert_query->bind_param("iii", $exam_id, $user_id, $totalScore);

            if ($insert_query->execute()) {
                echo "Exam results stored successfully!";
            } else {
                echo "Error: " . $conn->error;
            }

            $insert_query->close();
        }
    } else {
        echo "Invalid exam or user ID.";
    }

    $conn->close(); 
} else {
    echo "Invalid request. Please submit the form from the student page.";
}

// Function to calculate the total score based on submitted answers and question scores
function calculateTotalScore($submittedAnswers, $correctAnswers, $questionScores) {
    $totalScore = 0;

    foreach ($correctAnswers as $i => $correctAnswer) {
        if (isset($submittedAnswers["question_$i"]) && in_array($correctAnswer, $submittedAnswers["question_$i"])) {
            // Add the corresponding question score to the total score
            $totalScore += $questionScores[$i];
        }
    }
    print_r($totalScore);

    return $totalScore;
} 
?>
