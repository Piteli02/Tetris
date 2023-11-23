<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$databaseName = "Tetris";
$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
if ($conn->query($sql) === FALSE) {
  echo "Error creating database: " . $conn->error;
}

?>
