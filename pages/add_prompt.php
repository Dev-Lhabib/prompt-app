<?php
session_start();
require "../db.php";


if (!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}

$success = "";

if (isset($_POST['add_prompt'])){
  $title = $_POST['title'];
  $content = $_POST['content'];
  $category_id = $_POST['category_id'];
  $user_id = $_SESSION['user_id'];

  $check = $pdo->prepare("SELECT id FROM prompts WHERE title = ?");
  $check-> execute(['$title']);

  if ($check->fetch()){
    $error = "A prompt with this title already exists. Please choose a different title.";
  } else {
    $sql = "INSERT INTO prompts (title, content, user_id, category_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $user_id, $category_id]);
    $success = "Prompt added successfully!";
  }

}

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>
<link rel="stylesheet" href="style.css">
<h2>Add prompt</h2>
<a href="dashboard.php">⬅ Back</a>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error ?></p>  
<?php endif; ?>

<?php if ($success): ?>
  <p><?= $success ?></p>
<?php endif; ?>
<div>
  <form method="POST">
      <input type="text" name="title" placeholder="Title" required>

        <textarea name="content" placeholder="Write your prompt..." required></textarea>

        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= $cat['name'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
      <button type="submit" name="add_prompt">Add Prompt</button>
  </form>
</div>


