<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "call del_sub($subject_id);";

    if ($conn->query($sql) === TRUE) {
        header("Location: mainpage.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
