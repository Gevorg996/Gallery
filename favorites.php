<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'database-connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT images.id, images.path, images.name AS image_name, users.username
        FROM images
        JOIN users ON images.user_id = users.id
        JOIN favorites ON images.id = favorites.image_id
        WHERE favorites.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<?php
$title = "Favorites";
$css = "views/favorites.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
?>

<div class="favorites-container">
    <h1>Your Favorite Images</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="favorite-item">
                <a href="image_page.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo htmlspecialchars($row['path']); ?>" alt="<?php echo htmlspecialchars($row['image_name']); ?>">
                </a>
                <p><?php echo htmlspecialchars($row['image_name']); ?></p>
                <p>Uploaded by: <?php echo htmlspecialchars($row['username']); ?></p>
                <button class="like-button" data-image-id="<?php echo $row['id']; ?>">Unlike</button>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No favorite images found</p>
    <?php endif; ?>
</div>

<?php include "site_footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="scripts/favorites.js"></script>
</body>
</html>
