<?php

include 'verifica_logado.php';

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
    <!--Usuario terá que selecionar o tabuleiro novamente
    a nao ser que o js permita voltar para pagina
    especificada na selecao de tabuleiro-->

    <!--Solucões:
        *Colocar tanto tabuleiro 10x20 quanto 22x40 na mesma pagina? 
        *Permitir editar somente na selecao de tabuleiro, se acharem q é necessario um html
        para o tabuleiro 10x20 e outro para o 22x40

    -->
    <div class="containerCinza">
        <div class="containerCadastro">
            <form action="confirma_cadastro.html">
                <div class="contentCadastro">
                    <h1>Atualizar</h1>
                <div class="line"></div>
                <!--Nome-->
                <div class="cadastro_nome">
                    <label for="nome_completo">Nome Completo </label> 
                    <input type="text" id="nome_completo" placeholder="joão da silva" required>
                </div>
    
                <div class="cadastro_dtnasc-tel">
                    <div class="dt_nascimento">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" id="data_nascimento">
                    </div>
    
                    <div class="tel">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" placeholder="(11) 11111-1111">
                    </div>        
                </div>
    
                <div class="cadastro_cpf">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" placeholder="XXX.XXX.XXX-XX">
                </div>
                
                <!--Email-->
                <div class="cadastro_email">
                    <label for="email_usuario">Email</label>
                    <input type="email" id="email_usuario" placeholder="exemplo@email.com" required>
                </div>
                
                <!--Username-->
                <div class="cadastro_username">
                    <label for="username">Username </label> 
                    <input type="text" id="username" placeholder="joaozinMilgrau" required>
                </div>
    
                <div class="senha">
                    <!--Senha-->
                    <div class="cadastro_senha">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" placeholder="***********" required>
                    </div>
                    
                    <div class="confirma_senha">
                        <label for="senha_usuario">Confirmar senha</label>
                        <input type="password" id="senha_usuario" placeholder="***********" required>
                    </div>
                </div>
    
                <!--Termos
                <div class="cadastro_termos">
                    <input type="checkbox" id="consentimento" required>
                    <label for="consentimento">Aceito os <a href="termo_consentimento.html" target="_blank" rel="noopener noreferrer">Termos de Consentimento</a>.</label>
                </div>-->
                
                <div class="cadastrar">
                    <a href="tela_jogo_22x40.php">Atualizar</a>
                </div>
            </form> <!--ACTION SOMENTE VISUAL, COLOCAR AQUI NO FUTURO O CAMINHO PARA ONDE OS DADOS COLETADOS SERÃO ENVIADOS-->
            </div>
        </div>  
    </div>
    <!--GERAR MENSAGEM: PERFIL ATUALIZADO COM SUCESSO-->
</body>
</html>