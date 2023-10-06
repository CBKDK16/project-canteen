<!DOCTYPE html>
<html>
<head>
    <title>View Exam Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>View Exam Results</h1>
    <?php
    include 'config.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $exam_id = isset($_GET['examid']) ? $_GET['examid'] : null;
    echo "Exam ID: " . $exam_id;

    if (!empty($exam_id)) {
        $exam_query = "SELECT ex_title FROM examinfo_tbl WHERE ex_id = $exam_id";
        $result = $conn->query($exam_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $exam_title = $row['ex_title'];

            echo "<h2>Exam Title: $exam_title</h2>";

            $results_query = "SELECT user_form.name, exam_results.score
                             FROM exam_results
                             INNER JOIN user_form ON exam_results.user_id = user_form.id
                             WHERE exam_results.ex_id = $exam_id";

            $results_result = $conn->query($results_query);

            if ($results_result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>User Name</th><th>Score</th></tr>";

                while ($row = $results_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["score"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No results found for this exam.";
            }
        } else {
            echo "No exam found with the specified ID.";
        }
    } else {
        echo "Invalid exam ID.";
    }

    $conn->close();
    ?>
</body>
</html>
