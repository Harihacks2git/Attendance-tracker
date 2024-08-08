<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];

    include ('dbconnect.php');
    $sql = "INSERT INTO attendance(subject_id,date,hours) VALUES ($subject_id,'$date',$hours);";


    if ($conn->query($sql) === TRUE) {
        $sum_sql = "SELECT SUM(hours) as total_hours FROM attendance where subject_id = $subject_id";
        $res = $conn->query($sum_sql);
        $total_hours = 0;
        $percentage = 0.00;
        if($res->num_rows >0)
        {
            $row = $res->fetch_assoc();
            $total_hours = $row['total_hours'];
        }
        $conthrs_sql = "SELECT total_hours FROM subjects where id = $subject_id";
        $res1 = $conn->query($conthrs_sql);       
        $row = $res1->fetch_assoc();
        $conthours = $row['total_hours'];

        $percentage = (($conthours - $total_hours)/$conthours)*100;

        $update_stats = "UPDATE stats SET absent_hours = '$total_hours',attendance_percentage = '$percentage' WHERE subject_id = '$subject_id'";
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
        
        // echo "Error : ".$sql."<br>".$conn->error;
    }

    $conn->close();
}
?>
