<?php
$title = "Image Details";
$css = "views/image_page.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
include 'database-connection.php';

$image_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT images.path, images.name AS image_name, users.username
        FROM images
        JOIN users ON images.user_id = users.id
        WHERE images.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $image_id);
$stmt->execute();
$result = $stmt->get_result();
$image = $result->fetch_assoc();

$conn->close();
?>

<?php if ($image): ?>
    <div class="image-detail">
        <img src="<?php echo htmlspecialchars($image['path']); ?>" alt="<?php echo htmlspecialchars($image['image_name']); ?>">
        <h2><?php echo htmlspecialchars($image['image_name']); ?></h2>
        <p>Uploaded by: <?php echo htmlspecialchars($image['username']); ?></p>
    </div>
<?php else: ?>
    <p>Image not found.</p>
<?php endif; ?>

<?php include "site_footer.php"; ?>
