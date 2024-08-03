<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body { margin: 0; font-family: 'Lucida Sans', Geneva, Verdana, sans-serif; }
        .high { background-repeat: no-repeat; background-size: cover; height: 100vh; width: 100vw; background-image: url('gradient.jpg'); display: flex; justify-content: center; align-items: center; }
        .main { height: 400px; width: 300px; border-radius: 10px; background-color: transparent; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center; padding: 20px; position: relative; }
        .menu-button:hover { background-color: none; }
        .menu-button { position: absolute; top: 10px; left: 10px; background: none; border: none; font-size: 1.5em; cursor: pointer; color: grey; }
        .clickbuttons { display: flex; flex-direction: column; margin-top: 20px; justify-content: center; text-align: center; text-transform: capitalize; width: 100%; overflow-y: scroll; scrollbar-width: thin; scrollbar-color: transparent transparent; }
        .clickbuttons::-webkit-scrollbar { width: 6px; }
        .clickbuttons::-webkit-scrollbar-thumb { background-color: transparent; }
        .clickbuttons::-webkit-scrollbar-track { background-color: transparent; }
        .clickbutton { padding: 10px; border: none; border-radius: 10px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; margin-bottom: 20px; transition: background-color 0.3s ease; width: 250px; }
        .clickbutton:hover { background-color: grey; }
        .add-form { display: flex; flex-direction: column; align-items: center; }
        input[type="text"], input[type="number"] { padding: 10px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #ccc; width: 80%; }
        button[type="submit"] { padding: 10px; border: none; border-radius: 25px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; transition: background-color 0.3s ease; }
        button[type="submit"]:hover { background-color: grey; }
    </style>
</head>
<body>
    <div class="high">
        <div class="main">
            <button class="menu-button" onclick="location.href='logout.php'">←</button>
            <div class="clickbuttons">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'checkmate');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, subject_name, total_hours FROM subjects WHERE roll_no = '$roll_no'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<button class='clickbutton' onclick=\"location.href='attendance.php?subject_id={$row['id']}'\">{$row['subject_name']} ({$row['total_hours']} hrs)</button>";
                    }
                } else {
                    echo "No subjects found.";
                }

                $conn->close();
                ?>
            </div>
            <form class="add-form" action="add_subject.php" method="POST">
                <input type="text" name="subject_name" placeholder="Subject Name" required>
                <input type="number" name="total_hours" placeholder="Total Hours" required>
                <button type="submit">Add Subject</button>
            </form>
        </div>
    </div>
</body>
</html>
