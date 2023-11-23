<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$result = $conn->query("SHOW DATABASES LIKE '$dbname'");

if ($result->num_rows == 0) {
    $createDB = "CREATE DATABASE $dbname";
    if ($conn->query($createDB) === TRUE) {
        echo "Banco de dados criado com sucesso!<br>";
    } else {
        echo "Erro ao criar banco de dados: " . $conn->error . "<br>";
    }
} else {
    echo "O banco de dados já existe!<br>";
}

$conn->select_db($dbname);

$tableName1 = "jogadores";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName1'");

if ($tableExists->num_rows == 0) {
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
    $alterTableQuery = "ALTER TABLE partidas ADD COLUMN posicao_ranking INT AFTER pontos";

    if ($conn->query($alterTableQuery) === TRUE) {
        echo "Coluna 'posicao_ranking' adicionada com sucesso!<br>";
    } else {
        echo "Erro ao adicionar coluna: " . $conn->error . "<br>";
    }
} else {
    echo "A coluna 'posicao_ranking' já existe!<br>";
}

  $conn->close();

?>

