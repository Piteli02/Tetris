<?php

session_start();

if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$nome_completo = $_SESSION['nome_completo'];

$sql = "SELECT id FROM jogadores WHERE nome_completo = '$nome_completo'";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Erro na consulta: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_jogador = $row['id'];

    $_SESSION['id_jogador'] = $id_jogador;

    $tipo_partida = $_POST['tipo_partida'] ?? null;
    $pontuacao = $_POST['pontos'] ?? null;
    $nivel = $_POST['nivel'] ?? null;
    $tempo = $_POST['tempo_de_jogo'] ?? null;

        if ($nivel != 0) {
            if ($id_jogador !== null) {
                $sqlInsert = "INSERT INTO partidas (id_jogador, tipo_partida, pontos, tempo_de_jogo, nivel) VALUES ('$id_jogador', '1', '$pontuacao', '$tempo', '$nivel')";
                if ($conn->query($sqlInsert) === TRUE) {
                    echo "Dados inseridos com sucesso!";
        
                    $conn->query("UPDATE partidas SET posicao_ranking = (SELECT COUNT(*) FROM partidas p2 WHERE p2.tipo_partida = '1' AND p2.pontos >= partidas.pontos AND p2.id_jogador = partidas.id_jogador) WHERE tipo_partida = '1' AND id_jogador = '$id_jogador'");
                } else {
                    echo "Erro na inserção: " . $conn->error;
                }
            } else {
                echo "ID do jogador não encontrado.";
            }
        }
        
        $sqlRanking = "SELECT * FROM partidas WHERE id_jogador = '$id_jogador' AND tipo_partida = '1' ORDER BY posicao_ranking ASC LIMIT 10";
        $resultRanking = $conn->query($sqlRanking);
        
        $posicao = 1;
        while ($rowRanking = $resultRanking->fetch_assoc()) {
            echo "<tr class='rankings_tabela'>";
            echo "<td>#{$posicao}</td> <td>{$rowRanking['pontos']}</td> <td>{$rowRanking['nivel']}</td> <td>" . substr($rowRanking['tempo_de_jogo'], 0, 5) . "</td>";
            echo "</tr>";
            $posicao++;
        }

} else {
    die("Usuário não encontrado no banco de dados.");
}

$conn->close();

?>
