<?php
    include 'bd.php'; 

//coletando tag form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["Nome_completo"];
    $dataNascimento = $_POST["Data_nascimento"];
    $telefone = $_POST["Telefone"];
    $cpf = $_POST["Cpf"];
    $email = $_POST["Email_usuario"];
    $username = $_POST["Username"];
    $senha = $_POST["Senha"]; 
    $senhaConfirm = $_POST["Senha_usuario"];

    $conn = new mysqli("localhost", "root", "", "Tetris"); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($senha === $senhaConfirm) {
            $sql = "INSERT INTO jogadores (nome_completo, data_nascimento, telefone, cpf, email, username, senha)
            VALUES ('$nome', '$dataNascimento', '$telefone', '$cpf', '$email', '$username', '$senha')";
    } else {
        echo "<script>window.alert('As senhas são diferentes! Por favor, tente novamente.')</script>";
        header("Location: ./cadastro.php");
    }
       

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: ./index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}

$conn->close();
?>
