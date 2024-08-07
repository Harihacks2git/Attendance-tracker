<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $roll_no = $_GET['roll_no'];

    include ('dbconnect.php');

    $sql = " DELETE FROM subjects where id = $subject_id;";

    $att_del = "DELETE FROM attendance where subject_id = $subject_id";
    $stat_del = "DELETE FROM stats where subject_id = $subject_id AND roll_no = $roll_no";
    if($conn->query($att_del) == TRUE && $conn->query($stat_del) == TRUE)
    {
        if ($conn->query($sql) === TRUE) 
        {
            header("Location: mainpage.php");  
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
