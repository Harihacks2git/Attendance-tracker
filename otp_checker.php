<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $entered_otp = $_POST['otp'];
    
        if (!isset($_SESSION['otp']) || !isset($_SESSION['expiry'])) {
            $_SESSION['error'] = "OTP session expired. Please request a new OTP.";
            header("Location: signup.php");
            exit();
        }
    
        $stored_otp = $_SESSION['otp'];
        $expiry_time = $_SESSION['expiry'];
        
        // echo time();
        // echo "<br> $expiry_time";
        if (time() > $expiry_time) {
            $_SESSION['error'] = "OTP has expired. Please request a new OTP.";
            header("Location: index.php");
            exit();
        }
    
        if ($entered_otp == $stored_otp) {
            header("Location: password.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid OTP. Please try again.";
            header("Location: otp_verify.php");
            exit();
        }
    }
?>