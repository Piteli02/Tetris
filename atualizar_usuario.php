<?php
include 'verifica_logado.php';

$conexao = new mysqli("localhost", "root", "", "Tetris");

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['nome_completo'])) {
        die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
    }

    $nome_completo = $_SESSION['nome_completo'];

    $sqlId = "SELECT id FROM jogadores WHERE nome_completo = ?";
    $stmtId = $conexao->prepare($sqlId);
    $stmtId->bind_param("s", $nome_completo);
    $stmtId->execute();
    $resultId = $stmtId->get_result();

    if ($resultId === FALSE) {
        die("Erro na consulta: " . $conexao->error);
    }

    if ($resultId->num_rows > 0) {
        $rowId = $resultId->fetch_assoc();
        $id_jogador = $rowId['id'];

        $_SESSION['id_jogador'] = $id_jogador;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_jogador = isset($_SESSION['id_jogador']) ? $_SESSION['id_jogador'] : null;
        
            $nome_completo_sessao = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';
        
            $novo_nome_completo = $_POST['nome_completo'] ?? '';
            $nova_data_nascimento = $_POST['data_nascimento'] ?? '';
            $novo_telefone = $_POST['telefone'] ?? '';
            $novo_email = $_POST['email_usuario'] ?? '';
            $nova_senha = $_POST['senha'] ?? '';
        
            if ($novo_nome_completo !== $nome_completo_sessao) {
                $_SESSION['nome_completo'] = $novo_nome_completo;
            }
        
            $sqlUpdate = "UPDATE jogadores SET 
                nome_completo = ?, 
                data_nascimento = ?, 
                telefone = ?, 
                email = ?, 
                senha = ? 
                WHERE id = ?";
        
            $stmtUpdate = $conexao->prepare($sqlUpdate);
            $stmtUpdate->bind_param("sssssi", $novo_nome_completo, $nova_data_nascimento, $novo_telefone, $novo_email, $nova_senha, $id_jogador);
        
            if ($stmtUpdate->execute()) {
                if ($stmtUpdate->affected_rows > 0) {
                    echo "Dados atualizados com sucesso!";
                    header("Location: sel_tam_tabuleiro.php");
                    exit();
                } else {
                    echo "Nenhum dado foi atualizado.";
                    header("Location: sel_tam_tabuleiro.php");
                }
            } else {
                echo "Erro na atualização: " . $stmtUpdate->error;
            }
        
            $stmtUpdate->close();
        }
            } else {
                die("Usuário não encontrado no banco de dados.");
            }
            $stmtId->close();
        }
        
        $conexao->close();

?>
