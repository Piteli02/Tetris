<?php
include 'criar_bd.php';

if (isset($_POST['Email_usuario']) && isset($_POST['Senha'])) {
    // Verifique se a conexão foi estabelecida com sucesso
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Seleciona o banco de dados
    $conn->select_db("Tetris");

    $Email_usuario = $conn->real_escape_string($_POST['Email_usuario']);
    $Senha = $conn->real_escape_string($_POST['Senha']);

    $sql_code = "SELECT * FROM jogadores WHERE email = '$Email_usuario' AND senha = '$Senha'";
    $sql_query = $conn->query($sql_code) or die("Falha na execução do SQL: " . $conn->error);

    $qtd = $sql_query->num_rows;

    if ($qtd == 1) {
        $usuario = $sql_query->fetch_assoc();

        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['nome_completo'] = $usuario['nome_completo'];

        header("Location: sel_tam_tabuleiro.php");
        exit();
    } else {
        $erro_login = "Erro ao logar! E-mail ou senha incorretos.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirror Tetris - Login</title>
    <link rel="stylesheet" href="Styles/style_login.css">
    <script src="https://kit.fontawesome.com/fa3b748cb5.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">

        <div class="telaGameboy">

            
                <h1>Mirror Tetris</h1>

                <form action="" method="POST">
                    <div class="login">
                        <label for="Email_usuario">Email </label>
                        <input type="email"  name="Email_usuario" id="Email_usuario" placeholder="Insira seu email" required>
                    </div>

                    <div class="senha">
                        <label for="Senha">Senha </label>
                        <input type="password" name="Senha" id="Senha" placeholder="Insira sua senha" required>
                    </div>

                    <button type="submit" id="botao_continuar">Continuar</button>
                    
                    <div class="encaminhar_cadastro">
                        <p>Não tem uma conta?</p> <a href="cadastro.html">Cadastra-se já!</a>
                    </div>
                </form>

                <!-- Mensagem de erro (email ou senha incorretos) -->
                <?php if (!empty($erro_login)): ?>
                    <p style="color: red; display: flex; justify-content: center;"><?php echo $erro_login; ?></p>
                <?php endif; ?>
        </div>

        <div class="botoes_gameboy">
            <img id="direcional_gameboy" src="Assets/direcional.png" alt="direcional do gameboy">
            <img id="botaoA_gameboy" src="Assets/Ellipse2.png" alt="botao do gameboy">
            <img id="botaoB_gameboy" src="Assets/Ellipse2.png" alt="botao do gameboy">
        </div>
</div>

</body>
</html>