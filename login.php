<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'checkmate');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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
            header("Location: index.php");
    }

    $conn->close();
}
?>
