<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];

include ('dbconnect.php');

$sql = "DELETE FROM attendance WHERE roll_no = '$roll_no'";
if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: mainpage.php");
?>
