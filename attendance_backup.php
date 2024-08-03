<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

$subject_id = $_GET['subject_id'];
$roll_no = $_SESSION['roll_no'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <style>
        body { margin: 0; font-family: 'Lucida Sans', Geneva, Verdana, sans-serif; }
        .high { background-repeat: no-repeat; background-size: cover; height: 100vh; width: 100vw; background-image: url('gradient.jpg'); display: flex; justify-content: center; align-items: center; }
        .main { height: 400px; width: 300px; border-radius: 10px; background-color: transparent; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center; padding: 20px; position: relative; }
        .menu-button:hover { background-color: none; }
        .menu-button { position: absolute; top: 10px; left: 10px; background: none; border: none; font-size: 1.5em; cursor: pointer; color: grey; }
        .attendance-list { display: flex; flex-direction: column; margin-top: 20px; justify-content: center; text-align: center; text-transform: capitalize; width: 100%; overflow-y: scroll; scrollbar-width: thin; scrollbar-color: transparent transparent; }
        .attendance-list::-webkit-scrollbar { width: 6px; }
        .attendance-list::-webkit-scrollbar-thumb { background-color: transparent; }
        .attendance-list::-webkit-scrollbar-track { background-color: transparent; }
        .attendance-item { padding: 10px; border: none; border-radius: 10px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; margin-bottom: 20px; transition: background-color 0.3s ease; width: 250px; }
        .attendance-item:hover { background-color: grey; }
        .add-form { display: flex; flex-direction: column; align-items: center; }
        input[type="date"], input[type="number"] { padding: 10px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #ccc; width: 80%; }
        button[type="submit"] { padding: 10px; border: none; border-radius: 25px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; transition: background-color 0.3s ease; }
        button[type="submit"]:hover { background-color: grey; }
    </style>
</head>
<body>
    <div class="high">
        <div class="main">
            <button class="menu-button" onclick="location.href='mainpage.php'">←</button>
            <div class="attendance-list">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'checkmate');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, hours, date FROM attendance WHERE subject_id = $subject_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='attendance-item'>{$row['date']} - {$row['hours']} hrs</div>";
                    }
                } else {
                    echo "No attendance records found.";
                }

                $conn->close();
                ?>
            </div>
            <form class="add-form" action="add_attendance.php" method="POST">
                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                <input type="date" name="date" required>
                <input type="number" name="hours" placeholder="Hours" required>
                <button type="submit">Add Attendance</button>
            </form>
        </div>
    </div>
</body>
</html>
