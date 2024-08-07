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

    include ('dbconnect.php');
    $sql = "INSERT INTO subjects(roll_no,subject_name,total_hours) VALUES ($roll_no,'$subject_name',$total_hours);";
    
    if ($conn->query($sql) === TRUE) {
    $findsid = "SELECT id from subjects where subject_name = '$subject_name' and roll_no = '$roll_no'";
    $res = $conn->query($findsid);
    $row = $res->fetch_assoc();
    $subject_id = $row['id'];
    $sql2 = "INSERT INTO stats (roll_no,subject_id,contact_hours, absent_hours, attendance_percentage)
    VALUES ($roll_no,$subject_id,$total_hours, 0,100);";
    if($conn->query($sql2) == TRUE)
    {
        header("Location: mainpage.php");
    }
    else
    {
        echo "Error: ".$sql2."<br>".$conn->error;
    }
    } else {
        echo "Error: " . $sql ."\n".$sql2. "<br>" . $conn->error;
    }

    $conn->close();
}
?>
