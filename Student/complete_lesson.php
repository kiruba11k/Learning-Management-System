<?php
include('../dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_email = $_POST['user_email'];
    $lesson_id = $_POST['lesson_id'];
    $course_id = $_POST['course_id'];

    // Check if the lesson is already marked as completed
    $checkSql = "SELECT * FROM lesson_completion WHERE email = '$user_email' AND lesson_id = '$lesson_id'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        // Insert a new completion record
        $insertSql = "INSERT INTO lesson_completion (email, course_id, lesson_id, completed) VALUES ('$user_email', '$course_id', '$lesson_id', 1)";
        if ($conn->query($insertSql) === TRUE) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'already_completed';
    }
}
?>
