<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle Add
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    $_SESSION['success'] = "Category added successfully!";
    header("Location: categories.php");
    exit();
}

// Handle Update
if (isset($_POST['update'])) {
    $id   = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
    $_SESSION['success'] = "Category updated successfully!";
    header("Location: categories.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Check if category has prompts
    $check = $pdo->prepare("SELECT COUNT(*) FROM prompts WHERE category_id = ?");
    $check->execute([$id]);
    if ($check->fetchColumn() > 0) {
        $_SESSION['error'] = "Cannot delete: this category still has prompts.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Category deleted successfully!";
    }
    header("Location: categories.php");
    exit();
}

// Fetch category for editing
$editCat = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCat = $stmt->fetch();
}

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();
?>
<link rel="stylesheet" href="../assets/style.css">
<h2>Manage Categories</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?= $_SESSION['error'] ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<a href="dashboard.php">⬅ Back</a>
<br><br>

<?php if ($editCat): ?>
    <h3>Edit Category</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editCat['id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($editCat['name']) ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
<?php else: ?>
    <h3>Add Category</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Category name" required>
        <button type="submit" name="add">Add</button>
    </form>
<?php endif; ?>

<br>
<?php foreach ($categories as $cat): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <strong><?= htmlspecialchars($cat['name']) ?></strong>
        <br>
        <a href="categories.php?edit=<?= $cat['id'] ?>">Edit</a> |
        <a href="categories.php?delete=<?= $cat['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </div>
<?php endforeach; ?>
