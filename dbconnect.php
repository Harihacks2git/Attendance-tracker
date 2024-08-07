<?php
    $conn = new mysqli('localhost','root','','checkmate_wt');
    if ($conn->connect_error) {
        die('Error connecting to database'. $conn->connect_error);
    }
?>