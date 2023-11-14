<?php

include 'verifica_logado.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirro Tetris - Ranking Global</title>
    <link rel="stylesheet" href="Styles/style_rankingGlobal.css">
    <script src="https://kit.fontawesome.com/fa3b748cb5.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="containerCinza">

        <button id="btn_voltar">Voltar</button>

        <!-- Código para fazer o botão funcionar -->
        <script>
            // Pega o botão pelo id dele
            var botao_voltar = document.getElementById("btn_voltar");
        
            // Função responsável para levar para a outra página
            botao_voltar.onclick = function() {
                window.history.back();
            };
        </script>

        <div class="containerRanking">
            <div class="contentRanking">
                <h1>Ranking</h1>
                <div class="line"></div>
                <div class="tableRanking">
                    <table>
                        <tr class="no_background">
                            <th>Posição</th><th>Usuário</th> <th>Pontos</th> <th>Nível</th> <th>Tempo</th>
                        </tr>
    
                        <tr>
                            <td style="width: 50px;"><i class="fa-solid fa-trophy"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td><td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
    
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>
                        
                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>   

                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>   

                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>   

                        <tr>
                            <td><i class="fa-solid fa-medal"></i></td> <td>exemplo</td> <td>8000</td> <td>777</td> <td>20:00</td>
                        </tr>   
                    </table>
                </div>
            </div>
         </div>
    </div>
</body>
</html>