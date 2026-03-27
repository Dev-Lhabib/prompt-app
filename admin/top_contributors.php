<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$stmt = $pdo->query("
    SELECT users.username, COUNT(prompts.id) AS total_prompts
    FROM users
    LEFT JOIN prompts ON users.id = prompts.user_id
    GROUP BY users.id
    ORDER BY total_prompts DESC
");

$users = $stmt->fetchAll();
?>
<link rel="stylesheet" href="../assets/style.css">

<h2>Top Contributors</h2>
<br>
<a href="dashboard.php">⬅ Back</a>
<table border="1" cellpadding="10">
    <tr>
        <th>Username</th>
        <th>Prompts Count</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= $user['total_prompts']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
