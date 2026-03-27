<?php
session_start();
require '../config/db.php';

$error = '';

if (isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "select * from users WHERE email = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])){
    $_SESSION['role'] = $user['role'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    if ($user['role'] === 'admin') {
      header("Location: ../admin/dashboard.php");
    } else {
      header("Location: ../prompts/index.php");
    }
    exit();
  } else {
    $error = "Invalid email or password!";
  }
}
?>


<link rel="stylesheet" href="../assets/style.css">
<h3>Login</h3>
<div>
  <?php if ($error): ?>
    <p style="color: red; background-color: transparent; border-color: transparent;" class="error"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
    <a href="register.php">Create new account </a>
  </form>
</div>
