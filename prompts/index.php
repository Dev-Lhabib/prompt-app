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
?>
<link rel="stylesheet" href="../assets/style.css">

<h2>All Prompts</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<a href="create.php">+ Add Prompt</a>
<a href="prompts.php">Manage Prompts</a>

<br><br>
<a href="../auth/logout.php">Logout</a>

