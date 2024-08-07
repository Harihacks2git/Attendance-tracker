<?php  
    session_start();
    if(!isset($_SESSION['roll_no']))
    {
    header('Location: mainpage.php');
    exit();
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $roll_no = $_SESSION['roll_no'];
        $pass = $_POST['password'];
        include ('dbconnect.php');
        $s = "SELECT password FROM students where roll_no = $roll_no";
        $result = $conn->query($s);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            if(password_verify($pass, $row["password"]))
            {
                $sql = "call reset_sub($roll_no);";
                if($conn->query($sql) == true)
                {
                    echo "Subjects reset successfully";
                    header("Location: mainpage.php");
                }
                else
                {
                    echo "Error resetting subjects";
                }
            }
            else
            {
                $_SESSION['error'] = "Wrong password";
                header("Location: reset_subjects.php");
            }
        }
    }