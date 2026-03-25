<link rel="stylesheet" href="style.css">

<h3>Créer votre compte</h3>
<div>
  <form method="POST" action="register.php">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" placeholder="Entrez votre nom d'utilisateur" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="Entrez votre email" required><br><br>

    <label for="password">Mot de passe:</label>
    <input type="password" name="password" placeholder="Entrez votre mot de passe" required><br><br>

    <button type="submit" name="register">S'inscrire</button>
    <a href="login.php">Login to my account </a>
  </form>
</div>

<?php
session_start();
require '../db.php';

if (isset($_POST['register'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "insert into users (username, email, password) values(?, ?, ?)";  
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username, $email, $hashedPassword]);

  echo "User registered successfully!";

}
?>