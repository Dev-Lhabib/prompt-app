<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM prompts WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = "Prompt deleted successfully!";
    } else {
        $_SESSION['error'] = "Could not delete this prompt.";
    }
}

header("Location: prompts.php");
exit();
