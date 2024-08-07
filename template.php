<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}
if(isset($_SESSION['error'])) {
    $msg = $_SESSION['error'];
    unset($_SESSION['error']);
    echo "<script>alert('{$msg}');</script>";
}

$subject_id = $_GET['subject_id'];
$roll_no = $_SESSION['roll_no'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PercentageCalc</title>
<style>
    body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            /* height: 100px;
            width: 100px; */
            width: auto;
            height: auto;
            background-color:grey;
            color: #333;
            background-image:url('gradient.jpg');
            background-repeat: no-repeat;
            background-size:cover;
            backdrop-filter: blur(100px);
            scrollbar-width: none;
    }

        .pro-header {
            text-align: center;
            border-color: black;
            background-color:transparent;
            color:black;
            padding: 10px;
            margin-bottom: 20px;
            font-size:30px;
            
        }

        .full-div {
          
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 100vh;
            max-width: 100vw;
            width: 500px;
            height: auto;
            margin: 0 auto;
            background-color:transparent;
            backdrop-filter: blur(100px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-eee {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
        }
        .back-button{
            background-color: transparent;
            border: 1px solid;
            border-radius: 40px;
            color:rgba(0, 0, 0, 0.562);
        }
        .calculated-percentage {
            background-color:transparent;
            border: 1px solid;
            text-align: center;
            height: 40px;
            width: 200px;
            padding-top: 10px;
            padding-bottom: 1px;
            border-radius: 170px;
            margin-bottom: 20px;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
        }

        .total-div {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            align-items: center;
            margin-top: 10px;
            text-align: center;
        }

        .total-div div {
            padding: 10px;
        }
        form input {
           
             padding: 5px; 
             margin-bottom: 20px;
              border-radius: 6px; 
              border: 1px solid black;
             background-color: rgba(216, 214, 210, 0.1) 
            color: black;   
        }
        input,textarea{
            background-color: rgba(216, 214, 210, 0.1) 
        }
        .add-button{
            background-color: rgba(0, 0, 0, 0.562);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            margin-top: 20px;
        }
        .showstat,
        .reset,
        .nextbutton {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            margin-top: 20px;
        }
        .add-button:hover,
        .showstat:hover,
        .reset:hover {
            background-color: #2980b9;
        }

        .closestat {
            background-color: transparent;
            border-radius: 20px;
            border: 2px solid #bdc3c7;
            padding: 5px 10px;
            color: #333;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        .closestat:hover {
            background-color: #d0d3d4;
        }

        .dsa-div {
            text-align: center;
        }

        .para {
            display:flex;
            flex-direction: column;
            margin-left:auto;
            margin-right: auto;
            height: auto;
            width: auto;
            text-align: center;
            justify-content: center;
            align-items: center;
        }
        .button-div{
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
        .input-div{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .button-divhi{
            position: absolute;
        }
        .date-div{
            margin-top: 10px;
        }
        .summadelete{
            background-color:rgba(131, 4, 4, 0.137);
            height: 30px;
            width: 100px;
            padding:2px;
            border: 1px transparent;
            border-radius: 50px;
        }
        .button-divhi{
            left: 10px;
           top: 10px;
        }
        .attendance-list { display: flex; flex-direction: column; margin-top: 20px; justify-content: center; text-align: center; text-transform: capitalize; width: 100%; overflow-y: scroll; scrollbar-width: thin; scrollbar-color: transparent transparent; }
        .attendance-list::-webkit-scrollbar { width: 6px; }
        .attendance-list::-webkit-scrollbar-thumb { background-color: transparent; }
        .attendance-list::-webkit-scrollbar-track { background-color: transparent; }
        .stat{
            display: flex; 
            flex-direction: column; 
            align-items: center;
            max-height: 100px;
            width: 300px;
        border:1px solid grey;
        padding: 20px;
        border-radius: 10px; 
        margin-top: 10px;
        overflow: scroll;
        scrollbar-width: none;
        }
        .attendance-item{
            background-color: transparent;
            border: 1px solid grey;
            border-radius: 10px;
            width: 200px;
            height: 30px;
                }
                .delete-button{
                    color: red;
                    border: 1px solid grey;
                    border-radius: 10px;
                    width: 50px;
                    height: 30px;
                    background-color: transparent;
                }
</style>
</head>
<body>
    <header class="pro-header">PERCENTAGE CALC</header>
   <div class="full-div">
        <div class="button-divhi">
            <button class="back-button"onclick = "location.href='mainpage.php'">BACK</button>
        </div>
    <form class="form-eee" action = 'add_attendance.php' method = 'post'>
        <div class="gap"><p class="main-heading">Total Hours</p>
        <p class = "calculated-percentage" id = "absent_hours"></p>
        <p class="main-heading">Attendance_percentage</p>
        <p class="calculated-percentage" id = "attendance_percentage"></p>
        </div>
        <br>
        <div class="input-div">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
            <div class="hour-div">
                    <label for="DSA">Enter leave hours :</label>
                    <input type="text" name="hours" id="dsa" class="dsa" placeholder="total hours"  required>
            </div>
            <div class="date-div">
                    <label for="date">Enter Date :</label>
                    <input type="date" class="duedate" name="date" required>
            </div>
        </div>
        <div class="button-div">
            <!-- <button   type="button" class="reset" onclick="resetall();">RESET</button>
            <button type="button" class="showstat" onclick="dis()">show stats</button> -->
   
            <button type="submit"class="add-button">Add</button>
        </div>
        <div class = "stat">
            <?php
                include ('dbconnect.php');
                $s = "SELECT absent_hours,attendance_percentage FROM stats where subject_id = $subject_id";
                $res = $conn->query($s);
                $r = $res->fetch_assoc();
                echo "<script>
                            document.getElementById('absent_hours').innerHTML = {$r['absent_hours']};
                            document.getElementById('attendance_percentage').innerHTML = {$r['attendance_percentage']};
                      </script>";
                $sql = "SELECT id, hours, DATE_FORMAT(date,'%d/%M/%Y') as date FROM attendance WHERE subject_id = $subject_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div>
                                <button type = 'button' class='attendance-item'>{$row['date']} ({$row['hours']})</button>
                                <button  type = 'button' class='delete-button' onclick=\"location.href='delete_attendance.php?attendance_id={$row['id']}&subject_id=$subject_id'\">&#x1F5D1</button>
                              </div><br>";
                    }
                } else {
                    // echo"<br>";
                    echo "No attendance records found.";
                }

                $conn->close();
                ?>
            </div>
    </form>
    </div>
</body>
</html>