<?php
    session_start();
    if(isset($_SESSION['error']))
    {
        $errmsg = $_SESSION['error'];
        unset($_SESSION["error"]); 
        echo "<script>
                alert('{$errmsg}');
              </script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP verification</title>
    <style>
        body {
            margin: 0;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .high {
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            width: 100vw;
            background-image: url('gradient.jpg');
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            height: auto;
            width: 300px;
            border-radius: 10px;
            background-color:transparent;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .heading {
            text-align: center;
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        form input {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            flex:1;
            /* background-color: grey; */
            opacity: 0.4;
            border: 1px solid #ccc;
            width: calc(100% - 22px); Adjust width to fit padding and border
        }
        /* input{
          flex:1;
          width:300px;
        } */
        form input[type="submit"] {
            background-color: grey;
            border: none;
            border-radius: 50px;
            margin-left: 13px;
            cursor: pointer;
        }
        #password,#confirm_password{
            width: 100%;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            width: auto;
            height: 40px;
            transition: background-color 0.3s ease;
            background-color: transparent;
        }

        button:hover {
            background-color: grey;
            opacity: 0.6;
        }
        .show{
            background-color: grey;
            border: none;
            border-radius: 100px;
            color: black;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        button.show{
            background-color: transparent;
        }
        .in-1{
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            width: 100%;
            gap:10px;
        }
        .in-1 input{
            width: 100%;
        }
        .in-2{
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: center;
        }
        .pass{
            flex: 1;
        }
    </style>
    <script>
        function validatePasswordForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;

            if (!passwordPattern.test(password)) {
                alert("Password must be at least 6 characters long, contain at least one uppercase letter, one lowercase letter, and one number.");
                return false;
            }
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }

        function togglePasswordVisibility1() {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
        function togglePasswordVisibility2() {
            var passwordInput = document.getElementById('confirm_password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="high">
        <div class="main">
            <h2 class="heading">OTP</h2>
            <form action="otp_checker.php" method="post">
                <div class="in-1">
                <input type="number" id="password" class="pass" name="otp" required>
            </div><br>
                <input type = "submit"class="submit" value = "Verify OTP"/>
            </form>
        </div>
    </div>
</body>
</html>
