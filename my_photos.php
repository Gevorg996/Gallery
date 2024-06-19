<?php
session_start();
include 'database-connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = connectDB();

$stmt = $conn->prepare("SELECT id, filename, filepath FROM photos WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($photo_id, $filename, $filepath);
$photos = [];
while ($stmt->fetch()) {
    $photos[] = ['id' => $photo_id, 'filename' => $filename, 'filepath' => $filepath];
}
$stmt->close();
$conn->close();

$title = "My Photos";
$css = "views/my_photos.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
?>

<main>
<h2>My Photos</h2>
<form action="add_photo.php" method="post" enctype="multipart/form-data">
    <label for="photo">Upload new photo:</label>
    <input type="file" name="photo" id="photo" required>
    <button type="submit">Upload</button>
</form>
<br>
<?php if (count($photos) > 0): ?>
    <table class="photo-table">
        <tr>
            <th>Photo</th>
            <th>Filename</th>
            <th>Action</th>
        </tr>
        <?php foreach ($photos as $photo): ?>
            <tr>
                <td><img src="<?php echo htmlspecialchars($photo['filepath']); ?>" alt="<?php echo htmlspecialchars($photo['filename']); ?>" class="photo"></td>
                <td><?php echo htmlspecialchars($photo['filename']); ?></td>
                <td><a href="delete_photo.php?id=<?php echo $photo['id']; ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>You have no photos uploaded.</p>
<?php endif; ?>
</main>
<?php include "site_footer.php"; ?>