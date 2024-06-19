<?php
session_start();
include 'database-connection.php';

if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit;
}

$user_id = $_SESSION['user_id'];
$image_id = $_POST['image_id'];

// Check if the image is already a favorite
$sql = "SELECT * FROM favorites WHERE user_id = ? AND image_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $image_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If it is a favorite, remove it
    $sql = "DELETE FROM favorites WHERE user_id = ? AND image_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $image_id);
    $stmt->execute();
    echo 'unliked';
} else {
    // If it is not a favorite, add it
    $sql = "INSERT INTO favorites (user_id, image_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $image_id);
    $stmt->execute();
    echo 'liked';
}

$conn->close();
?>
