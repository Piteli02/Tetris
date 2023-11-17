<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Tetris";

//conectar
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Verifica se o banco de dados existe
$result = $conn->query("SHOW DATABASES LIKE '$database'");

if ($result->num_rows == 0) {
    // O banco de dados não existe, então podemos criá-lo
    $createDB = "CREATE DATABASE $database";
    if ($conn->query($createDB) === TRUE) {
        echo "Banco de dados criado com sucesso!<br>";
    } else {
        echo "Erro ao criar banco de dados: " . $conn->error . "<br>";
    }
} else {
    echo "O banco de dados já existe!<br>";
}

// Seleciona o banco de dados
$conn->select_db($database);

// Verifica se a tabela existe
$tableName1 = "jogadores";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName1'");

if ($tableExists->num_rows == 0) {
    // A tabela não existe, então podemos criá-la
    $createTable = "CREATE TABLE $tableName1 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_completo VARCHAR(255) NOT NULL,
        data_nascimento DATE,
        telefone VARCHAR(20),
        cpf VARCHAR(14),
        email VARCHAR(255) NOT NULL,
        username VARCHAR(50) NOT NULL,
        senha VARCHAR(255) NOT NULL
    )";

    if ($conn->query($createTable) === TRUE) {
        echo "Tabela criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela: " . $conn->error . "<br>";
    }
} else {
    echo "A tabela já existe!<br>";
}

$tableExists = 0;

$tableName2 = "partidas";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName2'");

if ($tableExists->num_rows == 0) {
    // A tabela não existe, então podemos criá-la
    $createTable = "CREATE TABLE $tableName2 (
        id_partida INT AUTO_INCREMENT PRIMARY KEY,
        id_jogador INT,
        tipo_partida int,
        pontos int,
        tempo_de_jogo time,
        nivel int,
        FOREIGN KEY(id_jogador) REFERENCES jogadores(id)
    )";

    if ($conn->query($createTable) === TRUE) {
        echo "Tabela criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela: " . $conn->error . "<br>";
    }
} else {
    echo "A tabela já existe!<br>";
}

$query = "SHOW COLUMNS FROM partidas LIKE 'posicao_ranking'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // A coluna não existe, então podemos adicioná-la
    $alterTableQuery = "ALTER TABLE partidas ADD COLUMN posicao_ranking INT AFTER pontos";

    if ($conn->query($alterTableQuery) === TRUE) {
        echo "Coluna 'posicao_ranking' adicionada com sucesso!<br>";
    } else {
        echo "Erro ao adicionar coluna: " . $conn->error . "<br>";
    }
} else {
    echo "A coluna 'posicao_ranking' já existe!<br>";
}

// Comando SQL para criar a tabela 'jogadores'
/*$sql1 = "CREATE TABLE jogadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    cpf VARCHAR(14),
    email VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);";

// Comando SQL para criar a tabela 'partidas'
$sql2 = "CREATE TABLE partidas(
    id_partida INT AUTO_INCREMENT PRIMARY KEY,
    id_jogador INT,
    tipo_partida int,
    pontos int,
    tempo_de_jogo time,
    nivel int,
    FOREIGN KEY(id_jogador) REFERENCES jogadores(id)
);";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}*/

  $conn->close();

?>

