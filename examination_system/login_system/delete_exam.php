<?php
if (isset($_GET["ex_id"])) {
    $ex_id = $_GET["ex_id"];

    @include 'config.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    $deleteResultsSQL = "DELETE FROM exam_results WHERE ex_id = ?";
    $stmt3 = $conn->prepare($deleteResultsSQL);
    $stmt3->bind_param("i", $ex_id);

    $deleteExamInfoSQL = "DELETE FROM examinfo_tbl WHERE ex_id = ?";
    $stmt1 = $conn->prepare($deleteExamInfoSQL);
    $stmt1->bind_param("i", $ex_id);

    $deleteQuestionsSQL = "DELETE FROM examquestion_tbl WHERE ex_id = ?";
    $stmt2 = $conn->prepare($deleteQuestionsSQL);
    $stmt2->bind_param("i", $ex_id);

    if ($stmt3->execute() && $stmt1->execute() && $stmt2->execute()) {
        $conn->commit();
        echo "Exam and related records deleted successfully.";
        echo '<a href="admin_page.php">Go back to Admin Page</a>';
    } else {
        $conn->rollback();
        echo "Error deleting exam and related records: " . $conn->error;
    }

    $stmt1->close();
    $stmt2->close();
    $stmt3->close();

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
