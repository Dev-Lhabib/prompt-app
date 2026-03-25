<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'] ?? $_POST['id'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];

    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);

    $_SESSION['success'] = "Category updated successfully!";
    header("Location: manage_categories.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();
?>
<link rel="stylesheet" href="style.css">

<h3>Edit Category</h3>

<form method="POST">
    <input type="text" name="name" value="<?= $cat['name'] ?>" required>
    <button type="submit" name="update">Update</button>
</form>