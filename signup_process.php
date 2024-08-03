<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];

    $conn = new mysqli('localhost','root','','checkmate');
    if ($conn->connect_error) {
        die('Error connecting to database'. $conn->connect_error);
    }
    $sql = "SELECT roll_no,name from students where roll_no = $roll_no";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $_SESSION['error'] = "User $roll_no already exits!";
        header("Location: index.php");
        exit();
    }
    $conn->close();

    // Store data in session to use in password setting page
    session_start();
    $_SESSION['roll_no'] = $roll_no;
    $_SESSION['name'] = $name;
    $_SESSION['phone_no'] = $phone_no;
    $_SESSION['email'] = $email;
    $_SESSION['department'] = $department;
    $_SESSION['semester'] = $semester;

    header("Location: password.php");
    exit();
}
?>