<?php
session_start();
include 'database-connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $photo_id = $_GET['id'];
    $conn = connectDB();

    $stmt = $conn->prepare("SELECT filepath FROM photos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $photo_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($filepath);
    $stmt->fetch();
    $stmt->close();

    if ($filepath && file_exists($filepath)) {
        unlink($filepath);

        $stmt = $conn->prepare("DELETE FROM photos WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $photo_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    
    $conn->close();
}

header("Location: myphotos.php");
exit();
?>
