<?php
/*
    include cria_bd.php; // EXECUTAR AMBOS SOMENTE 1 VEZ POR EXECUÇÃO, ATÉ FAZERMOS UM SCRIPT A PARTE
    include bd.php; //OU SEJA, NO PRIMEIRO TESTE DO BOTÃO DO COMMIT, COLOQUE ESSES INCLUDES. NOS SEGUINTES, PODE REMOVER PQ AÍ NÃO VAI FICAR TENTANDO CRIAR VARIOS BDS
*/

//coletando tag form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["Nome_completo"];
    $dataNascimento = $_POST["Data_nascimento"];
    $telefone = $_POST["Telefone"];
    $cpf = $_POST["Cpf"];
    $email = $_POST["Email_usuario"];
    $username = $_POST["Username"];
    $senha = password_hash($_POST["Senha"], PASSWORD_BCRYPT); //hash

    $conn = new mysqli("localhost", "root", "admin", "tetris"); //PARA CONFIGURAR O XAMPP, DA START NO MYSQL, DEPOIS CLIQUE EM SHELL, E, NO PROMPT, DIGITE: mysqladmin -u root password
                                                                //DEFINA SENHA PARA: adimin
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO jogadores (nome_completo, data_nascimento, telefone, cpf, email, username, senha)
    VALUES ('$nome', '$dataNascimento', '$telefone', '$cpf', '$email', '$username', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    /*
    
    $stmt = $conn->prepare("INSERT INTO jogadores (nome_completo, data_nascimento, telefone, cpf, email, username, senha) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $dataNascimento, $telefone, $cpf, $email, $username, $senha);

    if ($stmt->execute()) {
        // Redirecionar para a página de login
        header("Location: index.html");
    } else {
        echo "Erro ao cadastrar o jogador: " . $conn->error;
    }

    $stmt->close();
    */
}

$conn->close();
?>
