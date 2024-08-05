<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$_SESSION['signup'] = 'True';
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
    $sql2 = "SELECT roll_no,name from students where email = '$email'";
    $result2 = $conn->query($sql2);
    if($result2->num_rows > 0)
    {
        $_SESSION['error'] = "Email". $email." already exits for the roll no ".$roll_no."!";
        header("Location: signup.php");
        exit();
    }
    $sql = "SELECT roll_no,name from students where roll_no = $roll_no ";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $_SESSION['error'] = "User $roll_no already exits!";
        header("Location: index.php");
        exit();
    }
    $conn->close();


    $otp = rand(100000,999999);
    $expiry = time() + 1800;
    
    $_SESSION['otp'] = $otp;
    $_SESSION['expiry'] = $expiry;
    $_SESSION['otp_email'] = $email;

    
    $config = parse_ini_file(__DIR__."/config.ini",true);
    require 'libs/PHPMailer/src/Exception.php';
    require 'libs/PHPMailer/src/PHPMailer.php';
    require 'libs/PHPMailer/src/SMTP.php';

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);//validate the mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email address');
    }
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $config['mid'];
    $mail->Password = $config['mpass'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug = 3;

    $mail->setFrom($config['mid'],'Checkmate');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Signup request';
    $mail->Body = "Hi<br><br>The OTP for signing up with Checkmate The Attendance-tracker is<br><br>
                   <h1>$otp</h1><br><br>
                   This OTP will expire in 30 minutes!.";
    if (!$mail->send()) {
        $_SESSION['error'] = "Failed to send OTP. Please try again.";
        header("Location: signup.php");
        exit();
    }
    //Store data in session to use in password setting page
    session_start();
    $_SESSION['error'] = "OTP has been sent to your mail: ".$email.",Kindly check it!";
    $_SESSION['roll_no'] = $roll_no;
    $_SESSION['name'] = $name;
    $_SESSION['phone_no'] = $phone_no;
    $_SESSION['email'] = $email;
    $_SESSION['department'] = $department;
    $_SESSION['semester'] = $semester;
    header("Location: otp_verify.php");
    //header("Location: password.php");
    exit();
}
?>