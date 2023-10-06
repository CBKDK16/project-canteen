<?php
include 'config.php';
session_start(); 
if(isset($_GET['msg']))
{
    if($_GET['msg']==1)
    {
        $message[] = "Times Out";
    }
    elseif ($_GET['msg']==2) {
        $message[] = "You have already taken this exam. You cannot take it again.";
    }
    elseif ($_GET['msg']==3) {
        $message[] = "Exam taken Successfully";
    }
    elseif ($_GET['msg']==4) {
        $message[] = "Your result was't publish yet.";
    }
}



$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;



if (isset($_POST['btnExam'])) {

    $course_name = $_POST['course'];
    $exam_query = "SELECT ex_id, ex_title, ex_time_limit FROM examinfo_tbl WHERE course_name = '$course_name'";
    $result = $conn->query($exam_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $exam_id = $row['ex_id'];
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
            $message[] = "You have already taken this exam. You cannot take it again.";

        } else {
            header('Location: student_page.php?course=' . $course_name . '&id=' . $user_id);
            
        }
    }
}

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Course</title>
 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .view-results-button {
            display: block;
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            margin-top: 20px;
        }

        .view-results-button:hover {
            background-color: #2980b9;
        }
        .message{
           position: sticky;
           top:0;
           margin:0 auto;
           max-width: 1200px;
           background-color: var(--white);
           padding:2rem;
           display: flex;
           align-items: center;
           justify-content: space-between;
           z-index: 10000;
           gap:1.5rem;
        }

        .message span{
           font-size: 2rem;
           color:var(--black);
        }

        .message i{
           cursor: pointer;
           color:var(--red);
           font-size: 2.5rem;
        }

        .message i:hover{
           transform: rotate(90deg);
        }
    </style>
</head>
<body>
      <h1><marquee direction="right">Select a Course</marquee></h1>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="courseSelect">Select a Exam:</label>
        <select id="courseSelect" name="course">
            <?php

            include 'config.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $course_query = "SELECT DISTINCT course_name FROM examinfo_tbl";
            $result = $conn->query($course_query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $course_name = $row['course_name'];
                    echo "<option value=\"$course_name\">$course_name</option>";
                }
            } else {
                echo "<option value=\"\">No courses available</option>";
            }

            $conn->close(); 
            ?>
        </select> 
        <br>
        <input type="submit" value="Start Exam" name="btnExam">
    </form>
    <a href="view_result.php?user_id=<?php echo $user_id ?>" class="view-results-button">View Results</a>
</body>
</html>
