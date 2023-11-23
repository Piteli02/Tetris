<?php
session_start();

if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

$conexao = new mysqli("localhost", "root", "", "Tetris");

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

$nome_completo = $_SESSION['nome_completo'];
$sql = "SELECT * FROM jogadores WHERE nome_completo = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $nome_completo);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Erro na consulta: " . $conexao->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_jogador = $row['id'];

    $stmt->close();
} else {
    die("Usuário não encontrado no banco de dados.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome_completo = $_POST['nome_completo'] ?? '';
    $nova_data_nascimento = $_POST['data_nascimento'] ?? '';
    $novo_telefone = $_POST['telefone'] ?? '';
    $novo_email = $_POST['email_usuario'] ?? '';
    $nova_senha = $_POST['senha'] ?? '';

    if (!empty($nova_senha) && password_verify($nova_senha, $row['senha'])) {
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
            }
        } else {
            echo "Erro na atualização: " . $stmtUpdate->error;
        }
        
        if ($stmtUpdate->$stmt_id !== null) {
            $stmtUpdate->close();
        }
        
        
        if ($stmtUpdate->$stmt_id !== null) {
            $stmtUpdate->close();
        }
    } else {
        echo "A senha fornecida é inválida.";
    }
    echo "Nome Completo: " . $novo_nome_completo . "<br>";
}

$conexao->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirror Tetris - Editar Perfil</title>
    <link rel="stylesheet" href="Styles/style_editarCadastro.css">
</head>
<body>
    <div class="containerCinza">
        <div class="containerCadastro">
            <form action="atualizar_usuario.php" method="post">
                <div class="contentCadastro">
                    <h1>Atualizar</h1>
                    <div class="line"></div>
                    <div class="cadastro_nome">
                        <label for="nome_completo">Nome Completo </label> 
                        <input type="text" id="nome_completo" name="nome_completo" placeholder="joão da silva" value="<?= $row['nome_completo'] ?>" required>
                    </div>
    
                    <div class="cadastro_dtnasc-tel">
                        <div class="dt_nascimento">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $row['data_nascimento'] ?>">
                        </div>
    
                        <div class="tel">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" placeholder="(11) 11111-1111" value="<?= $row['telefone'] ?>">
                        </div>        
                    </div>
    
                    <div class="cadastro_cpf">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX" value="<?= $row['cpf'] ?>" readonly>
                    </div>
                    
                    <div class="cadastro_email">
                        <label for="email_usuario">Email</label>
                        <input type="email" id="email_usuario" name="email_usuario" placeholder="exemplo@email.com" value="<?= $row['email'] ?>" required>
                    </div>
                    
                    <div class="cadastro_username">
                        <label for="username">Username </label> 
                        <input type="text" id="username" name="username" placeholder="joaozinMilgrau" value="<?= $row['username'] ?>" required readonly>
                    </div>
                    
                    <div class="senha">
                        <div class="cadastro_senha">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" placeholder="***********" value="<?= $row['senha'] ?>">
                        </div>
                        
                    </div>
                    
                    <div class="cadastrar">
                        <button type="submit">Atualizar</button>
                    </div>
                </div>
            </form>
        </div>  
    </div>
</body>
</html>
