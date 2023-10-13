const canvas = document.getElementById("mirror_tetris");
const ctx = canvas.getContext("2d");

const LINHA  = 20;
const COLUNA = 10;
const tamQuadrado = 20;
const quadradoLivre = "#A6A6A6"; //cinza claro
let   tabuleiro = [];

//gerando o tabuleiro do tetris
for(lin = 0; lin < LINHA; lin++){
    tabuleiro[lin] = [];
    for(col = 0; col < COLUNA; col++){
        tabuleiro[lin][col] = quadradoLivre;
    }
}

/************************************
DEFININDO AS PECAS POSSIVEIS E SUAS ROTACOES

************************************/
const peca_I = [
    [
		[0, 0, 0, 0],
		[1, 1, 1, 1],
		[0, 0, 0, 0],
		[0, 0, 0, 0],
	],
	[
		[0, 0, 1, 0],
		[0, 0, 1, 0],
		[0, 0, 1, 0],
		[0, 0, 1, 0],
	],
	[
		[0, 0, 0, 0],
		[0, 0, 0, 0],
		[1, 1, 1, 1],
		[0, 0, 0, 0],
	],
	[
		[0, 1, 0, 0],
		[0, 1, 0, 0],
		[0, 1, 0, 0],
		[0, 1, 0, 0],
	]
];

const peca_O = [
    [
        [0, 0, 0, 0],
        [0, 1, 1, 0],
        [0, 1, 1, 0],
        [0, 0, 0, 0],
    ]
];

const peca_L = [
    [
        [0, 0, 1],
        [1, 1, 1],
        [0, 0, 0]
    ],
    [
        [0, 1, 0],
        [0, 1, 0],
        [0, 1, 1]
    ],
    [
        [0, 0, 0],
        [1, 1, 1],
        [1, 0, 0]
    ],
    [
        [1, 1, 0],
        [0, 1, 0],
        [0, 1, 0]
    ]
];

const peca_J = [
    [
        [1, 0, 0],
        [1, 1, 1],
        [0, 0, 0]
    ],
    [
        [0, 1, 1],
        [0, 1, 0],
        [0, 1, 0]
    ],
    [
        [0, 0, 0],
        [1, 1, 1],
        [0, 0, 1]
    ],
    [
        [0, 1, 0],
        [0, 1, 0],
        [1, 1, 0]
    ]
];

const peca_T = [
    [
        [0, 1, 0],
        [1, 1, 1],
        [0, 0, 0]
    ],
    [
        [0, 1, 0],
        [0, 1, 1],
        [0, 1, 0]
    ],
    [
        [0, 0, 0],
        [1, 1, 1],
        [0, 1, 0]
    ],
    [
        [0, 1, 0],
        [1, 1, 0],
        [0, 1, 0]
    ]
];

const peca_U = [
    [
        [1, 0, 1],
        [1, 1, 1],
        [0, 0, 0]
    ],
    [
        [0, 1, 1],
        [0, 1, 0],
        [0, 1, 1]
    ],
    [
        [0, 0, 0],
        [1, 1, 1],
        [1, 0, 1]
    ],
    [
        [1, 1, 0],
        [0, 1, 0],
        [1, 1, 0]
    ]

];

const peca_Especial = [
    [
        [0, 0, 0],
        [0, 1, 0],
        [0, 0, 0],
    ]
]; //baseado na peca_O, acredito q o mapeamento da peca_Especial fique assim, já q não tem como rotacionar ela

const pecasJogo = [

    [peca_I, "yellow"],
    [peca_O, "green"],
    [peca_L, "red"],
    [peca_J, "blue"],
    [peca_T, "purple"],
    [peca_U, "pink"],
    [peca_Especial, "orange"]

];

/***************************************
 * ************************************/



/****************************************
FUNCOES PARA A LÓGICA DO JOGO

definirTabuleiro() - varre todas as colunas do tabuleiro, até chegar ao final e, a cada posição, vai criando um quadrado. Ao atingir o limite de colunas, vai para a proxima linha, repetindo o mesmo procedimento até atingir o limite de linhas.
desenharQuadrado(x, y, cor) - recebe as coordenas x e y em que se deseja criar o quadrado, e preenche com a cor indicada no parâmetro.

******************************************/
function definirTabuleiro(){

    for(lin = 0; lin < LINHA; lin++){

        for(col = 0; col < COLUNA; col++){
            desenharQuadrado(col,       lin,        tabuleiro[lin][col]);
        }                   //eixo x    //eixo y
    }

}

function desenharQuadrado(x, y, cor){
    ctx.fillStyle = cor;
    ctx.fillRect(tamQuadrado * x, tamQuadrado * y, tamQuadrado, tamQuadrado);
    

    ctx.strokeStyle = "BLACK";
    ctx.strokeRect(tamQuadrado * x, tamQuadrado * y, tamQuadrado, tamQuadrado);
    
}

definirTabuleiro(); 

function Peca(nome_peca, cor){
    this.nome_peca = nome_peca;
    this.cor = cor;
    this.rotacao_atual = 0; //ao mudar esse numero, giramos a peca, pois estamos acessando o array associado ao nome, por exemplo peca_I[rotacao_atual], nesse caso, seria a peca I de pé
    this.pecaAtiva = this.nome_peca[this.rotacao_atual];
                
    //coordenadas
    this.x = 3;
    this.y = -2;
}
const apresentaProximaPeca = document.getElementById("proxima-peca"); 
let sorteioPecas = [];
//posicao 0 => proxima a ser jogada fora da fila
//posicao 1 => representa o numero aleaorio atual, ou seja, peca atual
//posicao 2 => representa a proxima que cairá no tabuleiro
//posicao 3 => reservado para guardar mais um numero aleatorio. Quando shift() for chamado, passará a ser 2


//preenchendo essa lista com 3 inteiros aleatorios, de 0 a 6
for(i = 0; i < 3; i++){
   sorteioPecas[i] = Math.floor(Math.random() * 7);
}

function gerarPecaAleatoria(){


   let nova_peca = new Peca(pecasJogo[  sorteioPecas[1]  ][0],   pecasJogo[  sorteioPecas[1]  ][1]); //instanciando a peça   
                               //coletando nome                    //coletando cor


   //colocar png indicando a proxima, que acessa sorteioPecas na posicao 2
   if(sorteioPecas[2] === 0) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_linha.png")'; //peca_I
   if(sorteioPecas[2] === 1) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_quadrado.png")'; //peca_O
   if(sorteioPecas[2] === 2) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_l.png")'; //peca_L
   if(sorteioPecas[2] === 3) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_lazul.png")'; //peca_J
   if(sorteioPecas[2] === 4) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_t.png")'; //peca_T
   if(sorteioPecas[2] === 5) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_u.png")'; //peca_u
   if(sorteioPecas[2] === 6) apresentaProximaPeca.style.backgroundImage = 'url("./Assets/peca_unica.png")'; //peca_especial
   //gerar aleatorio novo, na posicao 3
   sorteioPecas[3] = Math.floor(Math.random() * 7);


   //remover o primeiro elemento da fila de sorteiroPecas, o que atualiza o indice dos outros elementos
   sorteioPecas.shift();
   return nova_peca;
}
let peca = gerarPecaAleatoria();

//////////////METODOS DA "CLASSE" PECA/////////////////
Peca.prototype.desenhar_forma = function(){

    for(lin = 0; lin < this.pecaAtiva.length; lin++){

        for(col = 0; col < this.pecaAtiva.length; col++){
            if(this.pecaAtiva[lin][col]){
                desenharQuadrado(this.x + col, this.y + lin, this.cor);
            }
        }                   
    }
}

Peca.prototype.apagar_forma = function(){
    for(lin = 0; lin < this.pecaAtiva.length; lin++){

        for(col = 0; col < this.pecaAtiva.length; col++){
            if(this.pecaAtiva[lin][col]){
                desenharQuadrado(this.x + col, this.y + lin, quadradoLivre);
            }
        }                   
    }
}

Peca.prototype.descer_peca = function(){
    
    if(!this.colisaoPeca(0, 1, this.pecaAtiva)){
        this.apagar_forma();
        this.y++;
        this.desenhar_forma();
    } else{ //peca atingiu algo, necessario gerar outra no topo
        this.fixacaoPeca();
        peca = gerarPecaAleatoria();
    }
}

Peca.prototype.moverEsquerda = function(){//mesmo molde, apenas diminuir o eixo x
    
    if(!this.colisaoPeca(-1, 0, this.pecaAtiva)){
        this.apagar_forma();
        this.x--;
        this.desenhar_forma();
    }
    
}

Peca.prototype.moverDireita = function(){
    if(!this.colisaoPeca(1, 0, this.pecaAtiva)){
        this.apagar_forma();
        this.x++; //ir para direita -> incrementar o atributo que indica o eixo x da peca atual
        this.desenhar_forma();
    }
    
}

Peca.prototype.girarPeca = function(){
    let rotacao_seguinte = this.nome_peca[(this.rotacao_atual + 1) % this.nome_peca.length];
    let acertou_barreira_dir = false;
    let acertou_barreira_esq = false;
    let empurrar = 0;

    if(this.colisaoPeca(0, 0, rotacao_seguinte)){ //se a colisao ocorreu, nesse bloco if, descobre-se o lado em que ocorreu
        if(this.x > COLUNA / 2){
            acertou_barreira_dir = true;
            empurrar = -1;
        }else{
            acertou_barreira_esq = true;
            empurrar = 1;
        }
    }
    if(!this.colisaoPeca(empurrar, 0, rotacao_seguinte)){
        /*
        if (this.nome_peca !== peca_O && this.nome_peca !== peca_Especial){
        
            if(this.rotacao_atual !== 3){
                this.apagar_forma();
                this.x = this.x + empurrar;
                this.rotacao_atual++;
                this.pecaAtiva = this.nome_peca[this.rotacao_atual];
                this.desenhar_forma();
            } else{
                this.apagar_forma();
                this.x = this.x + empurrar;
                this.rotacao_atual = 0;
                this.pecaAtiva = this.nome_peca[this.rotacao_atual];
                this.desenhar_forma();
            }
        }*/
        
        this.apagar_forma();
        this.x += empurrar;
        this.rotacao_atual = (this.rotacao_atual + 1) % this.nome_peca.length;
        this.pecaAtiva = this.nome_peca[this.rotacao_atual];
        this.desenhar_forma();
    }
    
}

Peca.prototype.colisaoPeca = function(x, y, peca){
    for(lin = 0; lin < peca.length; lin++){

        for(col = 0; col < peca.length; col++){
            if(!peca[lin][col]){
                continue;
            }  //achou um quadrado que não esta livre

                let atualizaX = this.x + col + x; //x recebido no parametro
                let atualizaY = this.y + lin + y; //y recebido no parametro

                //criando barreiras que delimitam o tabuleiro
                if (atualizaX >= COLUNA || atualizaX < 0 || atualizaY >= LINHA){
                    return true;
                }
                if(atualizaY < 0){
                    continue;
                }
                if(tabuleiro[atualizaY][atualizaX] != quadradoLivre){
                    return true;
                }
            
        }                   
    }
    return false;
}

Peca.prototype.fixacaoPeca = function(){
    for(lin = 0; lin < this.pecaAtiva.length; lin++){

        for(col = 0; col < this.pecaAtiva.length; col++){
            if(!this.pecaAtiva[lin][col]){
                console.log("valor de gameover eh: "+ gameOver);
                continue;
            }
            //verificando fim de jogo
            if(this.y + lin < 0){
                alert("Game Over"); //Quem for fazer tela game over deve alterar essa parte
                gameOver = true;
                console.log("valor de gameover eh: "+ gameOver);
                break;
            }
            //pintando o canvas com essa peca que caiu
            tabuleiro[this.y+lin][this.x+col] = this.cor;
        }                   
    }
}
/////////////////////////////////////////////////////////

let tempo_tabuleiro = document.querySelector("#tempo_tabuleiro"); //será util para criarmos a function atualizarTempo nas proximas versoes
let tempo_anterior = Date.now();
let gameOver = false;
let velocidade_atual = 1000;
let save_velocidade_atual;

function descer_peca_automaticamente(){
    let tempo_atual = Date.now();
    let variacao = tempo_atual - tempo_anterior;
    if (variacao > velocidade_atual){
        peca.descer_peca();
        tempo_anterior = Date.now();
    }
    if(!gameOver){
        requestAnimationFrame(descer_peca_automaticamente);
    }
}

function descerRapido(){
    save_velocidade_atual = velocidade_atual;
    velocidade_atual = velocidade_atual / 20;  //aumentar o denominador caso desejar queda mais rapida
}

function restaurarVelocidade(){
        velocidade_atual = save_velocidade_atual;
}

/****************************************
******************************************/

/****************************************
EVENTOS DE CLICK E TECLAS
******************************************/
let verifica_espelhado = false;

let seta_para_baixo_press = false;

document.addEventListener("keydown", function(event) {
    if (!verifica_espelhado) {
        if (event.key === "ArrowRight") {
            peca.moverDireita();
        }
        
        if (event.key === "ArrowLeft") {
            peca.moverEsquerda();
        }
        
        if (event.key === "ArrowUp") {
            peca.girarPeca();
        }
        
        if (event.key === "ArrowDown") {
            if (!seta_para_baixo_press) {
                descerRapido();
                seta_para_baixo_press = true;
            }
        }
    } else { // Quando o tabuleiro está invertido
        if (event.key === "ArrowRight") {
            peca.moverEsquerda();
        }
        
        if (event.key === "ArrowLeft") {
            peca.moverDireita();
        }
        
        if (event.key === "ArrowDown") {
            peca.girarPeca();
        }
        
        if (event.key === "ArrowUp") {
            if (!seta_para_baixo_press) {
                descerRapido();
                seta_para_baixo_press = true;
            }
        }
    }
});

document.addEventListener("keyup", function(event) {
    if (!verifica_espelhado) {
        if (event.key === "ArrowDown") {
            seta_para_baixo_press = false;
            restaurarVelocidade();
        }
    } else { // Quando o tabuleiro está invertido
        if (event.key === "ArrowUp") {
            seta_para_baixo_press = false;
            restaurarVelocidade();
        }
    }
});

/****************************************
******************************************/

/****************************************
CHAMANDO AS FUNCOES
******************************************/

descer_peca_automaticamente();


let timer; // Variável para armazenar o timer
let seconds = 0, minutes = 0; // Inicialize os segundos e minutos com 0
let pontos = 0;
let linhas = 0;
let nivel = 0;
let nivelMin = 300;//mudar aqui para modificar de acordo com a velocidade

// Função para atualizar o cronômetro
function updateTimer() {
    seconds++;
    if (seconds == 60) {
        seconds = 0;
        minutes++;
    }

    const display = document.getElementById("cronometro");
    display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// Função para iniciar o cronômetro
function startTimer() {
    timer = setInterval(updateTimer, 1000);
}

// Iniciar o cronômetro automaticamente quando a página é carregada
window.addEventListener("load", startTimer);


function verificarLinhasCompletas() {
    let linhasCompletas = 0;
    let pecasEspeciaisEliminadas = 0;
    
    for (let lin = LINHA - 1; lin >= 0; lin--) {
        let linhaCompleta = true;
        
        for (let col = 0; col < COLUNA; col++) {
            if (tabuleiro[lin][col] === quadradoLivre) {
                linhaCompleta = false;
                break;
            }
        }

        if(pontos >= nivelMin * nivel){
            nivel += 1;
            document.getElementById("nivel").textContent = nivel;
            velocidade_atual -= 100;
        }

        
        if(linhaCompleta){
            //varrer ultima linha do tabuleiro para contar as pecas especiais encontradas
            for(i = lin, col = 0; col < COLUNA; col++){
                if (tabuleiro[i][col] === "orange") { //sinaliza peca especial foi encontrada
                    pecasEspeciaisEliminadas++;
                }
            }
        }
        
        if (linhaCompleta) {
            // Remove a linha completa
            for (let y = lin; y > 0; y--) {
                for (let col = 0; col < COLUNA; col++) {
                    tabuleiro[y][col] = tabuleiro[y - 1][col];
                }
            }

            // Preenche a primeira linha com quadrados livres
            for (let col = 0; col < COLUNA; col++) {
                tabuleiro[0][col] = quadradoLivre;
            }

            linhasCompletas++;
            lin++;
        }

    }
    switch (linhasCompletas) {
        case 1:
            linhas +=1;
            pontos += 10;
            document.getElementById("pontos").textContent = pontos;
            document.getElementById("linhas").textContent = linhas;
            break;
        case 2:
            linhas +=2;
            pontos += 40;
            document.getElementById("pontos").textContent = pontos;
            document.getElementById("linhas").textContent = linhas;
            break;
        case 3:
            linhas +=3;
            pontos += 90;
            document.getElementById("pontos").textContent = pontos;
            document.getElementById("linhas").textContent = linhas;
            break;
        case 4:
            linhas +=4;
            pontos += 160;
            document.getElementById("pontos").textContent = pontos;
            document.getElementById("linhas").textContent = linhas;
            break;
    }

    if (linhasCompletas > 0) {
        // Atualize a tela do jogo após remover as linhas completas
        definirTabuleiro();

        console.log("O programa detectou que " + pecasEspeciaisEliminadas +" peca_Especial foi eliminada");
        //depois de excluir a linha e definir o tabueleiro, falta verificar se a peca especial foi encontrada && eliminada
        //se sim, invertemos o tabuleiro e ativamos verifica_espelhamento para inverter os comandos do jogo
        if (pecasEspeciaisEliminadas % 2 != 0){
            espelharTabuleiro();
            verifica_espelhado = !verifica_espelhado;
            restaurarVelocidade();
            console.log("valor de verica_espelhado é " + verifica_espelhado)
        }
    }
    
}

// Chame a função verificarLinhasCompletas após cada queda de peça bem-sucedida
Peca.prototype.descer_peca = function () {
    if (!this.colisaoPeca(0, 1, this.pecaAtiva)) {
        this.apagar_forma();
        this.y++;
        this.desenhar_forma();
    } else { //peça atingiu algo, necessário gerar outra no topo
        this.fixacaoPeca();
        verificarLinhasCompletas(); // Verifique as linhas completas após a fixação da peça
        peca = gerarPecaAleatoria();
    }
}

function espelharTabuleiro(){
    //criando outro tabuleiro
    tabuleiro_espelhado = [];
    for(lin = 0; lin < LINHA; lin++){
        tabuleiro_espelhado[lin] = [];
        for(col = 0; col < COLUNA; col++){
            tabuleiro_espelhado[lin][col] = quadradoLivre;
        }
    }
    
    //copiando tudo do original, mas espelhado
    let col_espelho = COLUNA - 1;
    for (let lin = LINHA - 1; lin >= 0; lin--){

        for (let col = 0; col < COLUNA; col++, col_espelho --) {
            tabuleiro_espelhado[lin][col_espelho] = tabuleiro[lin][col];
        }

        col_espelho = COLUNA -1;
    }

    tabuleiro = tabuleiro_espelhado;
    definirTabuleiro(); //IMPORTANTE, SEM ELE, AS PECAS COLIDEM COM OUTRAS INVISÍVEIS

console.log("A cor capturada na ultima linha, coluna 9 é: " + tabuleiro_espelhado[19][0]);
}
