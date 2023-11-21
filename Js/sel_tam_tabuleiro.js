// Função para iniciar o jogo com base na opção selecionada
function iniciarJogo() {
    var selectedContainers = document.querySelectorAll('.tabuleiro .selected-container');
    
    // Verifique qual opção foi selecionada
    if (selectedContainers[0].style.opacity === '1') {
        // Opção 22x44 foi selecionada, redirecione para a tela correspondente
        window.location.href = "tela_jogo_22x40.php";
    } else if (selectedContainers[1].style.opacity === '1') {
        // Opção 10x20 foi selecionada, redirecione para a tela correspondente
        window.location.href = "tela_jogo_10x20.php";
    } else {
        // Nenhuma opção selecionada, exiba uma mensagem de erro ou ação padrão.
        alert("Por favor, selecione um tamanho de tabuleiro.");
    }
}
