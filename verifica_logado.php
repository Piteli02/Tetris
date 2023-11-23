<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

$nome_completo = $_SESSION['nome_completo'];

$conn = new mysqli("localhost", "root", "", "Tetris");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM jogadores WHERE nome_completo = '$nome_completo'";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Erro na consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_jogador = $row['id'];

    $_SESSION['id_jogador'] = $id_jogador;

} else {
    die("Usuário não encontrado no banco de dados.");
}

$conn->close();

?>
