<?php

// Inicia a conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "R00t@DuDu@2023";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter os dados do ranking global com o nome do jogador
$sqlRanking = "SELECT partidas.*, jogadores.nome_completo 
               FROM partidas 
               INNER JOIN jogadores ON partidas.id_jogador = jogadores.id
               ORDER BY pontos DESC LIMIT 10";

$resultRanking = $conn->query($sqlRanking);

// Exibir os dados do ranking global na tabela
$posicao = 1;
while ($rowRanking = $resultRanking->fetch_assoc()) {
    echo "<tr class='rankings_tabela'>";
    echo "<td>#{$posicao}</td> <td>{$rowRanking['nome_completo']}</td> <td>{$rowRanking['pontos']}</td> <td>{$rowRanking['nivel']}</td> <td>{$rowRanking['tempo_de_jogo']}</td> <td>{$rowRanking['tipo_partida']}</td>";
    echo "</tr>";
    $posicao++;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
