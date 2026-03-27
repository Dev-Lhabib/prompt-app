<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])){
  header("Location: ../auth/login.php");
  exit();
}

if ($_SESSION['role'] === 'admin') {
  header("Location: ../admin/dashboard.php");
  exit();
}

$sql = "SELECT prompts.*, users.username, categories.name AS category_name
FROM prompts
INNER JOIN users ON prompts.user_id = users.id
INNER JOIN categories ON prompts.category_id = categories.id";

$params = [];

if (!empty($_GET['category_id'])) {
    $sql .= " WHERE prompts.category_id = ?";
    $params[] = $_GET['category_id'];
}

$sql .= " ORDER BY prompts.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$prompts = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>
<link rel="stylesheet" href="../assets/style.css">

<h2>All Prompts</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?= $_SESSION['error'] ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<a href="create.php">+ Add Prompt</a>
<a href="index.php">⬅ Back</a>

<form method="GET">
    <?php $selectedCategory = $_GET['category_id'] ?? ''; ?>
    <select name="category_id">
      <option value="">-- All Categories --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id']; ?>"
        <?= ($selectedCategory == $cat['id']) ? 'selected' : ''; ?>>
        <?= htmlspecialchars($cat['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<?php foreach ($prompts as $prompt): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px;">
    <?php if ($prompt['user_id'] == $_SESSION['user_id']): ?>
      <a href="edit.php?id=<?= $prompt['id'] ?>">Edit</a> |
      <a href="delete.php?id=<?= $prompt['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    <?php endif; ?>
    <h3><?= htmlspecialchars($prompt['title']) ?></h3>
    <p><?= htmlspecialchars($prompt['content']) ?></p>
    <small>
      By <?= htmlspecialchars($prompt['username']) ?> |
      Category: <?= htmlspecialchars($prompt['category_name']) ?>
    </small>
  </div>
<?php endforeach; ?>
