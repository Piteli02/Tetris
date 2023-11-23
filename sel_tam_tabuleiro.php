<?php

include 'verifica_logado.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./Styles/styletam_tabuleiro.css" rel="stylesheet">
    <title>Mirror Tetris</title>
    <style>
        
    .tabuleiro {
        position: relative;
        
    }

    .tabuleiro img {
        width: 100%;
        height: 100%;
    }

    .tabuleiro .selected-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 50%; 
        max-height: 50%; 
        opacity: 0; 
        z-index: 1; 
    }

    nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1.5%;
    margin-bottom: 0;
}

.menu_voltar a {
    background-color: black;
    border-radius: 10px;
    padding: 10px;
    padding-left: 25px;
    padding-right: 25px;
    text-decoration: none;
    color: white;
    font-size: 30px;
}

</style>

<script src="Js/sel_tam_icone.js"> </script>

</head>

<body>
    <nav>
        <div class="container_voltar">
            <span class="menu_voltar">
                <a href="logout.php">Voltar</a>
            </span>
        </div>
    </nav>
    
    <div class="container">
        <div class="segundoback"> 
            <section class="title">
                <h1> Tamanho do Tabuleiro</h1>
                <hr>
            </section>
            <article class="tabuleiro" onclick="selecionarOpcao(this)">
                <img src="./Assets/tabuleiro22x44.png" alt="Tabuleiro 22x44">
                <div class="selected-container">
                    <img src="./Assets/selected.png" alt="Imagem Selecionada 1">
                </div>
                <h2>22 X 44</h2>
            </article>

            <article class="tabuleiro" onclick="selecionarOpcao(this)">
                <img src="./Assets/tabuleiro10x20.jpeg" alt="Tabuleiro 10x20">
                <div class="selected-container">
                    <img src="./Assets/selected.png" alt="Imagem Selecionada 2">
                </div>
                <h2>10 X 20</h2>
            </article>
            <div class="botao">
                <a href="#" onclick="iniciarJogo()">JOGAR</a>
            </div>
        </div>
    </div>


    <script src="Js/sel_tam_tabuleiro.js"></script>

</body>
</html>
