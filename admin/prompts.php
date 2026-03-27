<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])){
  header("Location: ../auth/login.php");
  exit();
}

if ($_SESSION['role'] !== 'admin') {
  header("Location: ../index.php"); 
  exit();
}

$sql = "SELECT prompts.*, users.username, categories.name AS category_name
FROM prompts
INNER JOIN users ON prompts.user_id = users.id
INNER JOIN categories ON prompts.category_id = categories.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$prompts = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>


<link rel="stylesheet" href="../assets/style.css">
<h2>Manage Categories</h2>

<a href="dashboard.php">⬅ Back</a>
<br><br>
<br>
<?php foreach ($prompts as $prompt): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px;">
    <h3><?= htmlspecialchars($prompt['title']) ?></h3>
    <p><?= htmlspecialchars($prompt['content']) ?></p>
    <small>
      By <?= htmlspecialchars($prompt['username']) ?> |
      Category: <?= htmlspecialchars($prompt['category_name']) ?>
    </small>
  </div>
<?php endforeach; ?>
