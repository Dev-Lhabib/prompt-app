<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'] ?? $_POST['id'];

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE prompts SET title = ?, content = ?, category_id = ? WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $category_id, $id, $_SESSION['user_id']]);

    $_SESSION['success'] = "Prompt updated successfully!";
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM prompts WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$prompt = $stmt->fetch();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<link rel="stylesheet" href="../assets/style.css">

<a href="index.php">⬅ Back</a>

<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($prompt['title']) ?>" required>
    <textarea name="content" required><?= htmlspecialchars($prompt['content']) ?></textarea>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $prompt['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="update">Update</button>
</form>
