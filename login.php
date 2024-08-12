<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $password = $_POST['password'];
    include ('dbconnect.php');

    $sql = "SELECT password FROM students WHERE roll_no = '$roll_no'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['roll_no'] = $roll_no;
            header("Location: mainpage.php");
        } else {
            $_SESSION['error']="Invalid credentials";
            header("Location: index.php");
        }
    } else {
            $_SESSION['error'] ="No such roll no exits. Try signing up";
            header("Location: signup.php");
    }

    $conn->close();
}
?>
