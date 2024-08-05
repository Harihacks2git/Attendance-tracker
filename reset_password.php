<?php
    session_start();
    $_SESSION['reset'] = 'True';
    include('dbconnect.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'libs/PHPMailer/src/Exception.php';
    require 'libs/PHPMailer/src/PHPMailer.php';
    require 'libs/PHPMailer/src/SMTP.php';

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);//validate the mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email address');
    }

    $otp = rand(100000,999999);
    $expiry = time() + 1800;
    
    $_SESSION['otp'] = $otp;
    $_SESSION['expiry'] = $expiry;
    $_SESSION['otp_email'] = $email;
    
    $config = parse_ini_file(__DIR__."/config.ini",true);
    $mail = new PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['mid'];
        $mail->Password = $config['mpass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPDebug = 3;

        $mail->setFrom('vanced7279@gmail.com','Checkmate');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Hi<br><br>The OTP to reset your Checkmate password is : <br><br>
                       <h1>$otp</h1><br><br>
                       This link will expire in 30 minutes!.";
        $mail->send();

        session_start();
        header("Location: otp_verify.php");
        exit();
    }
    catch(Exception $e)
    {
        die('Mail Error: '.$mail->ErrorInfo);
    }
    exit();
?>
