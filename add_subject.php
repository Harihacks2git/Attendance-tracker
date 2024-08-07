<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_SESSION['roll_no'];
    $subject_name = $_POST['subject_name'];
    $total_hours = $_POST['total_hours'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO subjects(roll_no,subject_name,total_hours) VALUES ($roll,$subject_name,$total_hours);";
    $sql2 = "    INSERT INTO stats (roll_no,contact_hours, absent_hours, attendance_percentage)
    VALUES ($roll_no,$total_hours, 0,100 ";
    if ($conn->query($sql) === TRUE && $conn->query($sql2)) {
        header("Location: mainpage.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
