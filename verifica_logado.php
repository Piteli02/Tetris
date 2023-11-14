<?php

if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['nome_completo'])) {
    die("Você precisa estar logado para acessar essa página. <p><a href=\"index.php\">Login</a></p>");
}

?>
