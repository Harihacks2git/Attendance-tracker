<?php
session_start();
if (!isset($_SESSION['roll_no'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];

    require 'database.php';
    $conn = connectDB();

    $sql = "DELETE FROM attendance WHERE subject_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $subject_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
