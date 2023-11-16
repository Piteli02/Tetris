<?php

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

// Obtém o id do jogador do banco de dados diretamente na verificação de login
$nome_completo = $_SESSION['nome_completo'];

// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "R00t@DuDu@2023", "tetris");

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obter o id do jogador a partir do nome_completo
$sql = "SELECT id FROM jogadores WHERE nome_completo = '$nome_completo'";
$result = $conn->query($sql);

// Verifica erros na consulta
if ($result === FALSE) {
    die("Erro na consulta: " . $conn->error);
}

// Verifica se algum resultado foi encontrado
if ($result->num_rows > 0) {
    // Obtém o primeiro resultado
    $row = $result->fetch_assoc();
    $id_jogador = $row['id'];

    // Armazena o id_jogador na sessão
    $_SESSION['id_jogador'] = $id_jogador;

    // Restante do seu código...
} else {
    // Lidar com o caso em que o usuário não foi encontrado no banco de dados
    die("Usuário não encontrado no banco de dados.");
}

// Fechar a conexão com o banco de dados
$conn->close();

// Restante do seu código...
?>
