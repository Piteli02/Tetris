<?php

session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

// Inicia a conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o ID do jogador do banco de dados diretamente na verificação de login
$nome_completo = $_SESSION['nome_completo'];

// Consulta para obter o ID do jogador a partir do nome_completo
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

    // Armazena o ID do jogador na sessão
    $_SESSION['id_jogador'] = $id_jogador;

    // Insere os dados da partida no banco de dados
    $tipo_partida = $_POST['tipo_partida'] ?? null;
    $pontuacao = $_POST['pontos'] ?? null;
    $nivel = $_POST['nivel'] ?? null;
    $tempo = $_POST['tempo_de_jogo'] ?? null;

        // Verificar se o nível não é zero antes de verificar a duplicação
        if ($nivel != 0) {
            // Verifica se o ID do jogador está definido
            if ($id_jogador !== null) {
                // Insere os dados diretamente no banco de dados
                $sqlInsert = "INSERT INTO partidas (id_jogador, tipo_partida, pontos, nivel, tempo_de_jogo) VALUES ('$id_jogador', '1', '$pontuacao', '$nivel', '$tempo')";
                if ($conn->query($sqlInsert) === TRUE) {
                    echo "Dados inseridos com sucesso!";
        
                    // Atualiza a posição_ranking na partida recém-inserida
                    $conn->query("UPDATE partidas SET posicao_ranking = (SELECT COUNT(*) FROM partidas p2 WHERE p2.tipo_partida = '1' AND p2.pontos >= partidas.pontos AND p2.id_jogador = partidas.id_jogador) WHERE tipo_partida = '1' AND id_jogador = '$id_jogador'");
                } else {
                    echo "Erro na inserção: " . $conn->error;
                }
            } else {
                echo "ID do jogador não encontrado.";
            }
        }
        
        // Consulta para obter os dados do ranking do jogador específico
        $sqlRanking = "SELECT * FROM partidas WHERE id_jogador = '$id_jogador' AND tipo_partida = '1' ORDER BY posicao_ranking ASC LIMIT 10";
        $resultRanking = $conn->query($sqlRanking);
        
        // Exibir os dados do ranking na tabela
        $posicao = 1;
        while ($rowRanking = $resultRanking->fetch_assoc()) {
            echo "<tr class='rankings_tabela'>";
            echo "<td>#{$posicao}</td> <td>{$rowRanking['pontos']}</td> <td>{$rowRanking['nivel']}</td> <td>" . substr($rowRanking['tempo_de_jogo'], 0, 5) . "</td>";
            echo "</tr>";
            $posicao++;
        }

} else {
    // Lidar com o caso em que o usuário não foi encontrado no banco de dados
    die("Usuário não encontrado no banco de dados.");
}

// Fechar a conexão com o banco de dados
$conn->close();

?>
