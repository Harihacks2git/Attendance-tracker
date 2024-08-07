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

    $sql = "INSERT INTO attendance(subject_id,date,hours) VALUES ($subject_id,$date,$hours);";


    if ($conn->query($sql) === TRUE) {
        $sum_sql = "SELECT SUM(hours) as total_hours FROM attendance where subject_id = $subject_id";
        $res = $conn->query($sum_sql);
        $total_hours = 0;
        if($res->num_rows >0)
        {
            $row = $res->fetch_assoc();
            $total_hours = $row['total_hours'];
        }
        $conthrs_sql = "SELECT total_hours FROM subjects where subject_id = $subject_id";
        $res = $conn->query($conthrs_sql);       
        $row = $res->fetch_assoc();
        $conthours = $row['total_hours'];

        $percentage = ((float)($conthours - $total_hours)/$conthours)*100;

        $update_stats = "UPDATE stats SET absent_hours = $total_hours,attendance_percentage = $percentage WHERE subject_id = $subject_id";
        if($conn->query($update_stats))
        {
            header("Location: template.php?subject_id=$subject_id");
        }
        else
        {
            echo "Error : ".$conn->error;
        }
    } else {
        $_SESSION['error'] = "Duplicate entry";
        header("Location: template.php?subject_id=$subject_id");
        exit();
    }

    $conn->close();
}
?>
