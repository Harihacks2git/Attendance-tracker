<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];


    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    include('dbconnect.php');

    // Insert data into the database if new signup
    if(isset($_SESSION['signup']))
    {
        // Retrieve data from session
        $roll_no = $_SESSION['roll_no'];
        $name = $_SESSION['name'];
        $phone_no = $_SESSION['phone_no'];
        $email = $_SESSION['email'];
        $department = $_SESSION['department'];
        $semester = $_SESSION['semester'];
        
        $sql = "INSERT INTO students (roll_no, name, phone_no, email, department, semester, password) 
                VALUES ('$roll_no', '$name', '$phone_no', '$email', '$department', '$semester', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['error'] = "Signup Successfull!";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if(isset($_SESSION['reset']))
    {
        $email = $_SESSION['otp_email'];
        $sql = "UPDATE students SET password = '$hashed_password' WHERE email = '$email'";
        if($conn->query($sql) == TRUE)
        {
            $_SESSION['error']= "Password reset successfull!";
            header("Location: index.php");
            exit();
        }
        else
        {
            echo "Error: ".$sql."<br>".$conn->error;
        }
    }
    $conn->close();
}
?>