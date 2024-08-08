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

                $sql = "DELETE FROM subjects where roll_no = $roll_no";

                $sel_sub_id = "SELECT id from subjects where roll_no = $roll_no";
                $res = $conn->query($sel_sub_id);
                if($res->num_rows>0)
                {
                    while($row = $res->fetch_assoc())
                    {
                        $subject_id = $row['id'];
                        $att_del = "DELETE FROM attendance where subject_id = $subject_id";
                        $stat_del = "DELETE FROM stats where subject_id = $subject_id AND roll_no = $roll_no";
                        if($conn->query($att_del) == FALSE || $conn->query($stat_del) == FALSE)
                        {
                            echo "Error ".$att_del."<br>".$stat_del."<br>".$conn->error;
                        }
                        else
                        {
                            if($conn->query($sql) == true)
                            {
                                echo "Subjects reset successfully";
                                header("Location: mainpage.php");
                            }
                            else
                            {
                                echo "Error resetting subjects".$conn->error;
                            }
                        }
                    }
                }
            }
            else
            {
                $_SESSION['error'] = "Wrong password";
                header("Location: reset_subjects.php");
            }
        }
    }