<?php
include 'verifica_logado.php';

// Conectar ao banco de dados (substitua as credenciais conforme necessário)
$conexao = new mysqli("localhost", "root", "", "Tetris");

// Verificar a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Processar os dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['nome_completo'])) {
        die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
    }

    // Obtém o ID do jogador do banco de dados diretamente na verificação de login
    $nome_completo = $_SESSION['nome_completo'];

    // Consulta para obter o ID do jogador a partir do nome_completo
    $sqlId = "SELECT id FROM jogadores WHERE nome_completo = ?";
    $stmtId = $conexao->prepare($sqlId);
    $stmtId->bind_param("s", $nome_completo);
    $stmtId->execute();
    $resultId = $stmtId->get_result();

    // Verifica erros na consulta
    if ($resultId === FALSE) {
        die("Erro na consulta: " . $conexao->error);
    }

    // Verifica se algum resultado foi encontrado
    if ($resultId->num_rows > 0) {
        // Obtém o primeiro resultado
        $rowId = $resultId->fetch_assoc();
        $id_jogador = $rowId['id'];

        // Armazena o ID do jogador na sessão
        $_SESSION['id_jogador'] = $id_jogador;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obter o ID do jogador
            $id_jogador = isset($_SESSION['id_jogador']) ? $_SESSION['id_jogador'] : null;
        
            // Obter o nome completo da sessão
            $nome_completo_sessao = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : '';
        
            // Obter os dados do formulário
            $novo_nome_completo = $_POST['nome_completo'] ?? '';
            $nova_data_nascimento = $_POST['data_nascimento'] ?? '';
            $novo_telefone = $_POST['telefone'] ?? '';
            $novo_email = $_POST['email_usuario'] ?? '';
            $nova_senha = $_POST['senha'] ?? '';
        
            // Verificar se o nome foi alterado
            if ($novo_nome_completo !== $nome_completo_sessao) {
                // Atualizar o nome na sessão
                $_SESSION['nome_completo'] = $novo_nome_completo;
            }
        
            // Atualizar os valores no banco de dados
            $sqlUpdate = "UPDATE jogadores SET 
                nome_completo = ?, 
                data_nascimento = ?, 
                telefone = ?, 
                email = ?, 
                senha = ? 
                WHERE id = ?";
        
            $stmtUpdate = $conexao->prepare($sqlUpdate);
            $stmtUpdate->bind_param("sssssi", $novo_nome_completo, $nova_data_nascimento, $novo_telefone, $novo_email, $nova_senha, $id_jogador);
        
            // Executar a atualização
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
                // Lidar com o caso em que o usuário não foi encontrado no banco de dados
                die("Usuário não encontrado no banco de dados.");
            }
        
            // Fechar a consulta preparada
            $stmtId->close();
        }
        
        // Fechar a conexão
        $conexao->close();

?>
