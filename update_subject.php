<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['subject_name'];
    $total_hours = $_POST['total_hours'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE subjects SET subject_name = '$subject_name', total_hours = $total_hours WHERE id = $subject_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: mainpage.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
