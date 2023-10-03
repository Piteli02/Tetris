const canvas = document.getElementById("mirror_tetris");
const ctx = canvas.getContext("2d");

const LINHA  = 20;
const COLUNA = 10;
const tamQuadrado = 20;
const quadradoLivre = "#A6A6A6" //cinza claro
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
        [0, 1, 0, 0],
        [0, 1, 0, 0],
        [0, 1, 0, 0],
        [0, 1, 0, 0]
    ],
    [
        [0, 0, 0, 0],
        [1, 1, 1, 1],
        [0, 0, 0, 0],
        [0, 0, 0, 0]
    ],
    [
        [0, 0, 1, 0],
        [0, 0, 1, 0],
        [0, 0, 1, 0],
        [0, 0, 1, 0]
    ],
    [
        [0, 0, 0, 0],
        [0, 0, 0, 0],
        [1, 1, 1, 1],
        [0, 0, 0, 0]
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
    

    ctx.strokeStyle = "BLACK"
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
    this.y = 0;
}
const PecaAleatoria = Math.floor(Math.random() * 7); //apenas testando os parametros. Estou gerando um numero de 0 a 6, então, a cada vez que salvarmos o arquivo, aparecerá uma peca aleatoria
let peca = new Peca(pecasJogo[PecaAleatoria][0],        pecasJogo[PecaAleatoria][1]); //instanciando a peça    
                    //coletando nome         //coletando cor

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
    this.apagar_forma();
    this.y++;
    this.desenhar_forma();
}

Peca.prototype.moverEsquerda = function(){//mesmo molde, apenas diminuir o eixo x
    this.apagar_forma();
    this.x--;
    this.desenhar_forma();
}

Peca.prototype.moverDireita = function(){
    this.apagar_forma();
    this.x++; //ir para direita -> incrementar o atributo que indica o eixo x da peca atual
    this.desenhar_forma();
}

Peca.prototype.girarPeca = function(){
    
    if (this.nome_peca !== peca_O && this.nome_peca !== peca_Especial){
        
        if(this.rotacao_atual !== 3){
            this.apagar_forma();
            this.rotacao_atual++;
            this.pecaAtiva = this.nome_peca[this.rotacao_atual];
            this.desenhar_forma();
        } else{
            this.apagar_forma();
            this.rotacao_atual = 0;
            this.pecaAtiva = this.nome_peca[this.rotacao_atual];
            this.desenhar_forma();
        }
    }
}


/////////////////////////////////////////////////////////

let tempo_tabuleiro = document.querySelector("#tempo_tabuleiro"); //será util para criarmos a function atualizarTempo nas proximas versoes
let tempo_anterior = Date.now();
let velocidade_atual = 1000;
let save_velocidade_atual;

function descer_peca_automaticamente(){
    let tempo_atual = Date.now();
    let variacao = tempo_atual - tempo_anterior;
    if (variacao > velocidade_atual){
        peca.descer_peca();
        tempo_anterior = Date.now();
    }
    requestAnimationFrame(descer_peca_automaticamente);
}

function descerRapido(){
    save_velocidade_atual = velocidade_atual;
    velocidade_atual = velocidade_atual / 6;  //aumentar o denominador caso desejar queda mais rapida
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
peca.desenhar_forma();
descer_peca_automaticamente();


