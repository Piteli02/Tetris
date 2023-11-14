<?php
$servername = "localhost";
$username = "root";
$password = "admin";

// Cria conexão
$conn = new mysqli($servername, $username, $password);
// Checa conexão
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Cria o banco de dados apenas se ele não existe ainda
$databaseName = "tetris";
$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
if ($conn->query($sql) === FALSE) {
  echo "Error creating database: " . $conn->error;
}

?>
