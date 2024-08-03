<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];
// $_SESSION['roll'] = $roll_no;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
       body {
    margin: 0;
    font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url('gradient.jpg'); /* Ensure the background image covers the viewport */
    background-size: cover;
    background-repeat: no-repeat;
    backdrop-filter: blur(100px); /* Adjust blur intensity as needed */
}
        .high { 
            background-repeat: no-repeat; 
            background-size: cover;
             height: 100vh;
              width: 100vw;
               /* background-image: url('gradient.jpg');  */
               display: flex;
                justify-content: center;
                 align-items: center;
                 /* backdrop-filter: blur(100px);  */
                }
        .main { height: 600px;
             width: 300px;
              border-radius: 10px;
               background-color: transparent; 
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
               display: flex;
                flex-direction: column;
                 align-items: center; 
                 padding: 20px;
                  position: relative;
                  backdrop-filter: blur(100px);
                 }
        .menu-button:hover { background-color: none; }
        .menu-button { position: absolute;
             top: 10px;
              left: 10px;
               background: none; 
               border: none; 
               font-size: 1.5em;
                cursor: pointer; 
                color: grey; }
.clickbuttons {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
    justify-content: center;
    text-align: center;
    text-transform: capitalize;
    width: 100%;
    overflow-y: auto; /* Change 'scroll' to 'auto' to display scrollbar only when necessary */
    scrollbar-width: thin; /* Use 'thin' for scrollbar width */
    scrollbar-color: transparent transparent;
}

.clickbuttons::-webkit-scrollbar {
    width: 6px;
}

.clickbuttons::-webkit-scrollbar-thumb {
    background-color: transparent; /* Make the scrollbar thumb transparent */
}

.clickbuttons::-webkit-scrollbar-track {
    background-color: transparent; /* Make the scrollbar track transparent */
}

.clickbutton {
    padding: 10px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.562);
    color: white;
    font-size: 1em;
    margin-bottom: 10px; /* Adjust margin to avoid overlapping buttons */
    transition: background-color 0.3s ease;
    width: 100%; /* Adjust width to fill container */
}

.clickbutton:hover {
    background-color: grey;
}

        .add-form { display: flex; 
            flex-direction: column; 
            align-items: center;
        border:1px solid grey;
        padding: 20px;
        border-radius: 10px; 
        margin-top: 10px;}

        input[type="text"], input[type="number"] {
             padding: 10px; 
             margin-bottom: 20px; 
             border-radius: 6px;
              border: 1px solid #ccc;
               width: 80%; }
        button[type="submit"], .edit-button, { 
            padding: 10px; 
            border: none; 
            border-radius: 25px; 
            cursor: pointer;
             
              color: white;
               font-size: 1em; 
               transition: background-color 0.3s ease;
             }
             .reset-but,.edit-button,.add-sub,.add-but{
                border: 1px solid grey;
                background-color: transparent;
                border-radius: 2px;
             }
             .clickbutton{
                background-color:rgba(0, 0, 0, 0.562);
                border: 1px solid grey;
                border-radius: 2px;
                overflow-y: scroll;
             }
             .del-button{
                color: red;
                margin-right: 10px;
             }
        button[type="submit"]:hover, .edit-button:hover { background-color: grey; }
        .reset-but {
            margin-left: 270px;
        }
        .div-button{
            margin-left: 10px;
            display: flex;
            flex-direction: row-reverse;
            margin-bottom: 10px;
            justify-content: right;
        }
        .contain-click{
            height: auto;
            width: 300px;
                 display: block;
                 margin-top: 50px;
                 overflow-y: scroll;
                 scrollbar-width: thin; /* Use 'thin' for scrollbar width */
                scrollbar-color: transparent transparent;
        }
    </style>
</head>
<body>
    <div class="high">
        <div class="main">
        <button class="menu-button" onclick="location.href='logout.php'">←</button>
            <button class="reset-but" onclick = "location.href='reset_subjects.php'">RESET</button><div>
        <form class="add-form" action="add_subject.php" method="POST">
                <input type="text" name="subject_name" placeholder="Subject Name" required>
                <input type="number" name="total_hours" placeholder="Total Hours" required>
                <button type="submit" class="add-sub">Add Subject</button>
            </form>
            </div>
            <div  class="contain-click">
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
                        echo "<div>
                                <button class='clickbutton' onclick=\"location.href='template.php?subject_id={$row['id']}'\">{$row['subject_name']} ({$row['total_hours']} hrs)</button>
                               <div class='div-button'> <button class='edit-button' onclick=\"location.href='edit_subject.php?subject_id={$row['id']}&subject_name={$row['subject_name']}&total_hours={$row['total_hours']}'\">&#9998;</button>
                                <button class='del-button' onclick=\"location.href='delete_subject.php?subject_id={$row['id']}&subject_name={$row['subject_name']}&total_hours={$row['total_hours']}'\">&#x1F5D1;</button></div>
                              </div>";
                    }
                } else {
                    echo "No subjects found.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
