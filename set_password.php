<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Retrieve data from session
    $roll_no = $_SESSION['roll_no'];
    $name = $_SESSION['name'];
    $phone_no = $_SESSION['phone_no'];
    $email = $_SESSION['email'];
    $department = $_SESSION['department'];
    $semester = $_SESSION['semester'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'checkmate');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO students (roll_no, name, phone_no, email, department, semester, password) 
            VALUES ('$roll_no', '$name', '$phone_no', '$email', '$department', '$semester', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['error'] = "Signup Successfull!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>