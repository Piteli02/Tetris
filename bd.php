<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$database = "tetris";

//conectar
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Comando SQL para criar a tabela 'jogadores'
$sql1 = "CREATE TABLE jogadores (
    id UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    cpf VARCHAR(14),
    email VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
)";

// Comando SQL para criar a tabela 'partidas'
$sql2 = "CREATE TABLE partidas (
    id_partida UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_jogador INT,
    pontos int,
    tempo_de_jogo time,
    FOREIGN KEY(id_jogador) REFERENCES jogadores(id)
)";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

  
  $conn->close();

?>

