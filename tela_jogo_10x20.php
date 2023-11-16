<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/style_teladojogo.css">
    <title>Mirror Tetris - 10x20</title>
</head>
<body>

    <!--Div para que quando o jogo acabe a tela de fundo fique escura-->
    <div class="overlay"></div>

    <nav>
        <div class="container_voltar">
            <span class="menu_voltar">
                <a href="sel_tam_tabuleiro.php">Voltar</a>
            </span>
        </div>

        <div class="container_opcoes">
            <span class="menu_editarprofile">
                <a href="editar_profile.php"><img src="Assets/pessoa_2.png" alt="icone de pessoa para acessar o editar profile"></a> <!--feito-->
            </span>

            <span class="menu_ranking">
                <a href="ranking_global.php"><img src="Assets/trofeu_5.png" alt="icone de trofeu para acessar o ranking global"></a> <!--feito-->
            </span>
        </div>
    </nav>

    <!--servirá de conteiner para todo o quadrado central da pagina, que foi projetada
    no Figma com o nome GameScreen2-->
    <main>
        <div class="container">

            <!--Div para que quando o jogo acabe a tela fique escura-->
            
            <div class="container_jogo_principal">

                <!--Aqui será usada a tag canva-->
                <div class="container_tabuleiro">
                    <canvas id="mirror_tetris" width="200" height="400"></canvas>
                </div>

                <div class="container_estatisticas">
                    <div class="container_template">
                        <p>Pontos</p>
                        <hr>
                        <p id="pontos">0</p>     
                    </div>

                    <div class="container_template">
                        <p>Nível</p>
                        <hr>
                        <p id="nivel">1</p>
                    </div>

                    <div class="container_template">
                        <p>Lines</p>
                        <hr>
                        <p id="linhas">0</p>    
                    </div>

                    <div class="container_template">
                        <p id="tempo_tabuleiro">Tempo</p>
                        <hr>
                        <p id="cronometro">00:00</p>

                    </div>

                    <div class="container_template">
                        <p>Prox</p>
                        <hr>
                        <div id="proxima-peca" class="peca"></div>
                    </div>
                </div>
            </div>
            <div class="container_ranking_pessoal">
            <p>Ranking pessoal</p>
                <hr>
                 <form id="dadosForm" action="ranking.php" method="post">
                    <input type="hidden" name="id_jogador" id="nivel-hidden" value="">
                    <input type="hidden" name="tipo_partida" id="tempo-hidden" value="">
                    <input type="hidden" name="pontos" id="pontuacao-hidden" value="">
                    <input type="hidden" name="nivel" id="nivel-hidden" value="">
                    <input type="hidden" name="tempo_de_jogo" id="tempo-hidden" value="">
                </form>
                <table>
                    <tr>
                    <th>Posição</th><th>Pontos</th> <th>Nível</th> <th>Tempo</th>
                    </tr>


                    <?php
                    include 'ranking.php';
                    ?>


                </table>
            </div>
        </div>
        <div id="tela-game-over" class="container_game_over">
            <p>Acabou o jogo</p>
            
            <div class="estatisticas_finais">
                <table>
                    <tr>
                        <td class="estatistica_tipo">Pontos</td> <td id="pontuacao-final" class="estatistica_numero">0</td>
                    </tr>

                    <tr>
                        <td class="estatistica_tipo">Ranking pessoal</td> <td class="estatistica_numero">X</td>
                    </tr>

                    <tr>
                        <td class="estatistica_tipo">Ranking global</td> <td class="estatistica_numero">X</td>
                    </tr>

                    <tr>
                        <td class="estatistica_tipo">Tempo de jogo</td> <td id="tempo-final" class="estatistica_numero">00:00</td>
                    </tr>
                </table>

                <a href="tela_jogo_10x20.php"><img src="Assets/reiniciar.png" alt="icone de reiniciar jogo"></a>
                <p>Jogar de novo</p>
            </div>
        </div>
    </main>
    <script src="Js/jogo_10x20.js"></script>
</body>
</html>