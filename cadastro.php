<?php

include "bd.php";

//coletando tag form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome_completo"];
    $dataNascimento = $_POST["data_nascimento"];
    $telefone = $_POST["telefone"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email_usuario"];
    $username = $_POST["username"];
    $senha = password_hash($_POST["senha"], PASSWORD_BCRYPT); //hash

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO jogadores (nome_completo, data_nascimento, telefone, cpf, email_usuario, username, senha)
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
