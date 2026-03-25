<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">
<h2>Welcome <?= htmlspecialchars($_SESSION['username']); ?> 👋</h2>

<?php if ($_SESSION['role'] == 'admin'): ?>
    <h3>Admin Dashboard</h3>
    <a href="manage_categories.php">Manage Categories</a>
    <a href="top_contributors.php">View Top Contributors</a>
<?php else: ?>
    <h3>Developer Dashboard</h3>
    <a href="add_prompt.php">Add Prompt</a>
    <a href="prompts.php">View Prompts</a>
<?php endif; ?>

<br><br>
<a href="logout.php">Logout</a>