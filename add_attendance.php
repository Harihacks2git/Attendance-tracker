<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "call ins_att('$subject_id','$date','$hours');";

    if ($conn->query($sql) === TRUE) {
        header("Location: template.php?subject_id=$subject_id");
    } else {
        $_SESSION['error'] = "Duplicate entry";
        header("Location: template.php?subject_id=$subject_id");
exit();
    }

    $conn->close();
}
?>
