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
        [1, 0, 1]
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

const gerarPecaAleatoria = Math.floor(Math.random() * 7); //apenas testando os parametros. Estou gerando um numero de 0 a 6, então, a cada vez que salvarmos o arquivo, aparecerá uma peca aleatoria
let peca = new Peca(pecasJogo[gerarPecaAleatoria][0],        pecasJogo[gerarPecaAleatoria][1]); //instanciando a peça    
                    //coletando nome         //coletando cor

Peca.prototype.desenhar_forma = function(){

    for(lin = 0; lin < this.pecaAtiva.length; lin++){

        for(col = 0; col < this.pecaAtiva.length; col++){
            if(this.pecaAtiva[lin][col]){
                desenharQuadrado(this.x + col, this.y + lin, this.cor);
            }
        }                   
    }
}


//enquanto o operador new instanciou a minha "classe" Peca
//prototype me permitiu acessar as variaveis dessa classe e criar o metodo desenhar_forma()
//Testando o uso desse metodo
peca.desenhar_forma();
/***************************************
 * ************************************/