<?php
session_start();
require "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // $sql = "DELETE FROM prompts WHERE id = ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$id]);
    $sql = "DELETE FROM prompts WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
}

header("Location: prompts.php");
exit();