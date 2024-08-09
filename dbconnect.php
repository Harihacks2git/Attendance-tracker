<?php
    $conn = new mysqli('sql312.infinityfree.com','if0_37046410','WXulzTiwRja','if0_37046410_checkmate');
    if ($conn->connect_error) {
        die('Error connecting to database'. $conn->connect_error);
    }
?>