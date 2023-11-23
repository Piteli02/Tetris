<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
            $sqlInsert = "INSERT INTO partidas (id_jogador, tipo_partida, pontos, nivel, tempo_de_jogo) VALUES ('$id_jogador', '2', '$pontuacao', '$nivel', '$tempo')";
            if ($conn->query($sqlInsert) === TRUE) {
                echo "Dados inseridos com sucesso!";
            } else {
                echo "Erro na inserção: " . $conn->error;
            }
        } else {
            echo "ID do jogador não encontrado.";
        }
    }

    $sqlRanking = "SELECT * FROM partidas WHERE id_jogador = '$id_jogador' AND tipo_partida = '2' ORDER BY pontos DESC LIMIT 10";
    $resultRanking = $conn->query($sqlRanking);

    $posicao = 1;
    while ($rowRanking = $resultRanking->fetch_assoc()) {
        echo "<tr class='rankings_tabela'>";
        echo "<td>#{$posicao}</td> <td>" . ($rowRanking['pontos'] ?? '') . "</td> <td>" . ($rowRanking['nivel'] ?? '') . "</td> <td>" . ($rowRanking['tempo_de_jogo'] ?? '') . "</td>";
        echo "</tr>";

        $posicao++;
    }

} else {
    die("Usuário não encontrado no banco de dados.");
}

$conn->close();

?>
