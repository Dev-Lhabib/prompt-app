<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../prompts/index.php");
    exit();
}
?>
<link rel="stylesheet" href="../assets/style.css">
<h2>Welcome <?= htmlspecialchars($_SESSION['username']); ?> 👋</h2>

<?php if ($_SESSION['role'] == 'admin'): ?>
    <h3>Admin Dashboard</h3>
    <a href="categories.php">Manage Categories</a>
    <a href="prompts.php">View Prompts</a>
    <a href="top_contributors.php">View Top Contributors</a>
<?php else: ?>
    <h3>Developer Dashboard</h3>
    <a href="../prompts/create.php">Add Prompt</a>
    <a href="../prompts/index.php">View Prompts</a>
<?php endif; ?>

<br><br>
<a href="../auth/logout.php">Logout</a>
