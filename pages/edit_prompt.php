<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$success = '';

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    // $sql = "UPDATE prompts SET title = ?, content = ? WHERE id = ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$title, $content, $id]);
    
    $sql = "UPDATE prompts SET title = ?, content = ?, category_id = ? WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $category_id, $id, $_SESSION['user_id']]);

    $_SESSION['success'] = "Prompt updated successfully!";
    
    header("Location: prompts.php");
    exit();
}

$sql = "SELECT * FROM prompts WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$prompt = $stmt->fetch();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<link rel="stylesheet" href="style.css">

<?php if ($success): ?>
    <p><?= $success ?></p>
<?php endif; ?>
<a href="dashboard.php">⬅ Back</a>

<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>"> 
    <input type="text" name="title" value="<?= $prompt['title'] ?>" required>
    <textarea name="content" required><?= $prompt['content'] ?></textarea>
    <?php 
        $stmt = $pdo->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll();
    ?>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $prompt['category_id'] ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>

        <?php endforeach; ?>
    </select>

    <button type="submit" name="update">Update</button>
</form>