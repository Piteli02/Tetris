<?php
    // !! RESOLVIDO !!  
   // include 'criar_bd.php'; // EXECUTAR AMBOS SOMENTE 1 VEZ POR EXECUÇÃO, ATÉ FAZERMOS UM SCRIPT A PARTE
    include 'bd.php'; //OU SEJA, NO PRIMEIRO TESTE DO BOTÃO DO COMMIT, COLOQUE ESSES INCLUDES. NOS SEGUINTES, PODE REMOVER PQ AÍ NÃO VAI FICAR TENTANDO CRIAR VARIOS BDS

//coletando tag form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["Nome_completo"];
    $dataNascimento = $_POST["Data_nascimento"];
    $telefone = $_POST["Telefone"];
    $cpf = $_POST["Cpf"];
    $email = $_POST["Email_usuario"];
    $username = $_POST["Username"];
    $senha = $_POST["Senha"]; //tirei a criptografia por enquanto

    $conn = new mysqli("localhost", "root", "", "tetris"); //PARA CONFIGURAR O XAMPP, DA START NO MYSQL, DEPOIS CLIQUE EM SHELL, E, NO PROMPT, DIGITE: mysqladmin -u root password
                                                                //DEFINA SENHA PARA: admin
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO jogadores (nome_completo, data_nascimento, telefone, cpf, email, username, senha)
    VALUES ('$nome', '$dataNascimento', '$telefone', '$cpf', '$email', '$username', '$senha')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: ./index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}

$conn->close();
?>
