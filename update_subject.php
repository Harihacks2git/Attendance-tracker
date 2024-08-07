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

    include ('dbconnect.php');

    $sql = "UPDATE subjects SET subject_name = '$subject_name', total_hours = $total_hours WHERE id = $subject_id";

    if ($conn->query($sql) === TRUE) {
        $sel_old = "SELECT total_hours from subjects where id = $subject_id";
        $res = $conn->query($sel_old);
        $row =$res->fetch_assoc(); 
        $old_hours = $row['total_hours'];    
        if($old_hours != $total_hours)
        {
            $new_hours = $total_hours;
            $sel_stat_abs = "SELECT absent_hours from stats where subject_id = $subject_id";
            $res = $conn->query($sel_stat_abs);
            $row = $res->fetch_assoc();
            $abs = $row['absent_hours'];
            $percentage = ((float)($new_hours-$abs)/$new_hours)*100;
            $update_stats = "UPDATE stats SET contact_hours = $new_hours,attendance_percentage = $percentage where subject_id = $subject_id";
            if($conn->query($update_stats) == TRUE)
            {
                header("Location: mainpage.php");
            }
            else
            {
                echo "Error: " . $update_stats . "<br>" . $conn->error;  
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
