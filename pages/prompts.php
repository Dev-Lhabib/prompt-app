<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id'])){
  header("Location: login.php");
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

$stmt = $pdo->query("SELECT * FROM  categories ORDER BY name ASC");
$categories = $stmt->fetchAll();

?>
<link rel="stylesheet" href="style.css">

<h2>All prompts</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<a href="dashboard.php">⬅ Back</a>

<form method="GET">
    <?php $selectedCategory = $_GET['category_id'] ?? ''; ?>
    <select name="category_id">
      <option value="">-- All Categories --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id']; ?>"
        <?= ($selectedCategory == $cat['id']) ? 'selected' : ''; ?>>

        <?= htmlspecialchars($cat['name']); ?>
        </option>
      <?php endforeach;?>
    </select>
    <button type="submit">Filter</button>
</form>

<?php foreach ($prompts as $prompt): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px;">
    <a href="edit_prompt.php?id=<?= $prompt['id'] ?>">Edit</a> |
    <a href="delete_prompt.php?id=<?= $prompt['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    <h3><?= $prompt['title']?></h3>
    <p><?= $prompt['content'] ?></p>
    <small>
      By <?= $prompt['username'] ?> |
      Category: <?= $prompt['category_name'] ?>
    </small>
  </div>
<?php endforeach; ?>








