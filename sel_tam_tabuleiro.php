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
        
    /* CSS para posicionar as imagens sobre as imagens de fundo */
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
        max-width: 50%; /* Defina o tamanho máximo desejado, como 50% */
        max-height: 50%; /* Defina o tamanho máximo desejado, como 50% */
        opacity: 0; /* Inicialmente, a imagem está invisível */
        z-index: 1; /* Certifique-se de que o contêiner da imagem selecionada está acima da imagem de fundo */
    }

</style>

<script src="Js/sel_tam_icone.js"> </script>

</head>
<body>
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
