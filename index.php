<?php
$title = "Home";
$css = "views/home.css";
$headerCss = "views/site_header.css";
$footerCss = "views/site_footer.css";
include "site_header.php";
include 'database-connection.php';

$images_per_page = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $images_per_page;

$sql = "SELECT images.id, images.path, images.name AS image_name, users.username
        FROM images
        JOIN users ON images.user_id = users.id
        LIMIT $offset, $images_per_page";

$result = $conn->query($sql);

$total_images_result = $conn->query("SELECT COUNT(*) AS total FROM images");
$total_images = $total_images_result->fetch_assoc()['total'];
$total_pages = ceil($total_images / $images_per_page);

$conn->close();
?>

<div class="gallery-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="gallery-item">
                <a href="image_page.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo htmlspecialchars($row['path']); ?>" alt="<?php echo htmlspecialchars($row['image_name']); ?>">
                </a>
                <p><?php echo htmlspecialchars($row['image_name']); ?></p>
                <p>Uploaded by: <?php echo htmlspecialchars($row['username']); ?></p>
                <button class="like-button" data-image-id="<?php echo $row['id']; ?>">Like</button>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No images found</p>
    <?php endif; ?>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="scripts/favorites.js"></script>

<?php include "site_footer.php"; ?>
