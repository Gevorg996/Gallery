<?php
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "your_db_password";
    $dbname = "galerry";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
