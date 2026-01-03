<?php
// includes/db.php

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "fowzi_store";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");
?>
