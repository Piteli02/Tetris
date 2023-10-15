// Função para lidar com a seleção da opção
function selecionarOpcao(element) {
    // Ocultar todos os contêineres de imagem selecionada
    var selectedContainers = document.querySelectorAll('.tabuleiro .selected-container');
    selectedContainers.forEach(function(container) {
        container.style.opacity = 0;
    });

    // Exibir o contêiner da imagem da opção selecionada
    var selectedContainer = element.querySelector('.selected-container');
    selectedContainer.style.opacity = 1;
}