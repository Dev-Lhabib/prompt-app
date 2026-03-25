<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();
?>
<link rel="stylesheet" href="style.css">
<h2>Manage Categories</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<a href="add_category.php">+ Add Category</a>
<a href="dashboard.php">⬅ Back</a>
<br><br>

<?php foreach ($categories as $cat): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <strong><?= $cat['name'] ?></strong>
        <br>
        <a href="edit_category.php?id=<?= $cat['id'] ?>">Edit</a> |
        <a href="delete_category.php?id=<?= $cat['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </div>
<?php endforeach; ?>