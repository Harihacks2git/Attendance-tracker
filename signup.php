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
    <title>Signup</title>
    <style>
        body {
            margin: 0;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
        }

        .main {
            height: auto;
            background-color: transparent;
            width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;

        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 20px;
        }

        form input, form select {
            width: calc(50% - 10px);
            padding: 10px;
            border-radius: 6px;
            border: 1px solid black;
            background-color: transparent;
            color: black;
            transition: border-color 0.3s ease;
        }
        option{
            background-color: grey;
            opacity: 0.1;
        }
        form input:focus, form select:focus {
            border-color: grey;
            outline: none;
        }

        form input[type="submit"] {
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 25px;
            background-color: grey;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: grey;
        }

        .back-button {
            background-color: grey;
            /* border: 1px solid black; */
     border: none;
            border-radius: 30px;
            cursor: pointer;
            color: white;
            padding:10px 10px;
            font-size: 1em;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .back-button:hover {
            color: black;
        }
         .next-button{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
         }
        .high {
            background-image: url("gradient.jpg");
            backdrop-filter: blur(100px);
            height: 100vh;
            width: 100vw;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            background-repeat: no-repeat;
        }
    </style>
    <script>
        function validateSignupForm() {
            var rollNo = document.getElementById('roll_no').value;
            var name = document.getElementById('name').value;
            var phoneNo = document.getElementById('phone_no').value;
            var email = document.getElementById('email').value;
            var department = document.getElementById('department').value;
            var semester = document.getElementById('semester').value;
            var rollNoPattern = /^20\d{8}$/;
            var phonePattern = /^\d{10}$/;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (!rollNoPattern.test(rollNo)) {
                alert("Roll number must start with '20' and be 10 digits long.");
                return false;
            }
            if (!name.trim()) {
                alert("Name is required.");
                return false;
            }
            if (!phonePattern.test(phoneNo)) {
                alert("Phone number must be 10 digits long.");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("Invalid email address.");
                return false;
            }
            if (!department) {
                alert("Department is required.");
                return false;
            }
            if (semester < 1 || semester > 8) {
                alert("Semester must be between 1 and 8.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="high">
        <div class="main">
            <button class="back-button" onclick="location.href='index.php'">← Back</button>
            <h2>SIGNUP</h2>
            <form action="signup_process.php" method="post" onsubmit="return validateSignupForm()">
                <div class="input-group">
                    <input type="text" id="roll_no" name="roll_no" placeholder="Roll No">
                    <input type="text" id="name" name="name" placeholder="Name">
                </div>
                <div class="input-group">
                    <input type="text" id="phone_no" name="phone_no" placeholder="Phone No">
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>
                <div class="input-group">
                    <select id="department" name="department">
                        <option value="">Select Department</option>
                        <option value="Computer Engineering">Computer Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Civil Engineering">Civil Engineering</option>
                        <option value="Electronics Engineering">Electronics Engineering</option>
                    </select>
                    <select id="semester" name="semester">
                        <option value="">Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="next-button">
                <input type="submit" class="next-button" value="Next">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
