<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['attendance_id']) && isset($_GET['subject_id'])) {
    $attendance_id = $_GET['attendance_id'];
    $subject_id = $_GET['subject_id'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    include ('dbconnect.php');

    $sql = "DELETE FROM attendance where id = $attendance_id; ";

    if ($conn->query($sql) === TRUE) {
        $abs = 0;
        $cont = 0;
        $per = 0.0;

        $sql_abs = "SELECT SUM(hours) AS abs FROM attendance WHERE subject_id = $subject_id";
        $result_abs = $conn->query($sql_abs);

        if ($result_abs && $row = $result_abs->fetch_assoc()) {
            $abs = $row['abs'];
        }

        if ($abs !== null) {

            $sql_cont = "SELECT total_hours AS cont FROM subjects WHERE id = $subject_id";
            $result_cont = $conn->query($sql_cont);
            
            if ($result_cont && $row = $result_cont->fetch_assoc()) {
                $cont = $row['cont'];
            }

            if ($cont > 0) {
                $per = (($cont - $abs) / $cont) * 100;
            }
        } else {
            $abs = 0;
            $per = 100.0;
        }
        $sql_update = "UPDATE stats SET absent_hours = $abs, attendance_percentage = $per WHERE subject_id = $subject_id";
        if($conn->query($sql_update) == TRUE)
        {
            header("Location: template.php?subject_id=$subject_id");
        }
        else
        {
            echo "Error : ".$conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
