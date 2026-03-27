<?php
$servername = "localhost";
$port     = "3307";
$username = "root";
$password = "";
$dbname = "prompt_app";

try {
  $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
}catch (PDOException $e){
  die("Connection faild: " . $e->getMessage());
}