<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

$subject_id = $_GET['subject_id'];
$subject_name = $_GET['subject_name'];
$total_hours = $_GET['total_hours'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <style>
        body { margin: 0; font-family: 'Lucida Sans', Geneva, Verdana, sans-serif; }
        .high { background-repeat: no-repeat; background-size: cover; height: 100vh; width: 100vw; background-image: url('gradient.jpg'); display: flex; justify-content: center; align-items: center; }
        .main { height: 400px; width: 300px; border-radius: 10px; background-color: transparent; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center; padding: 20px; position: relative; }
        .menu-button:hover { background-color: none; }
        .menu-button { position: absolute; top: 10px; left: 10px; background: none; border: none; font-size: 1.5em; cursor: pointer; color: grey; }
        .add-form { display: flex; flex-direction: column; align-items: center; }
        input[type="text"], input[type="number"] { padding: 10px; margin-bottom: 20px; border-radius: 6px; border: 1px solid #ccc; width: 80%; }
        button[type="submit"] { padding: 10px; border: none; border-radius: 25px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; transition: background-color 0.3s ease; }
        button[type="submit"]:hover { background-color: grey; }
    </style>
</head>
<body>
    <div class="high">
        <div class="main">
            <button class="menu-button" onclick="location.href='mainpage.php'">←</button>
            <form class="add-form" action="update_subject.php" method="POST">
                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                <input type="text" name="subject_name" placeholder="Subject Name" value="<?php echo $subject_name; ?>" required>
                <input type="number" name="total_hours" placeholder="Total Hours" value="<?php echo $total_hours; ?>" required>
                <button type="submit">Update Subject</button>
            </form>
        </div>
    </div>
</body>
</html>
