<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);

    header("Location: manage_categories.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">

<h3>Add Category</h3>
<form method="POST">
    <input type="text" name="name" placeholder="Category name" required>
    <button type="submit" name="add">Add</button>
    <a href="dashboard.php">⬅ Back</a>
</form>