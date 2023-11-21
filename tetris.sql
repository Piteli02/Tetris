create database Tetris;
use Tetris;

drop database Tetris;

CREATE TABLE jogadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    cpf VARCHAR(14),
    email VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE partidas(
    id_partida INT AUTO_INCREMENT PRIMARY KEY,
    id_jogador INT,
    tipo_partida int,
    pontos int,
    tempo_de_jogo time,
    nivel int,
    FOREIGN KEY(id_jogador) REFERENCES jogadores(id)
);
ALTER TABLE partidas ADD COLUMN posicao_ranking INT AFTER pontos;

select * from partidas;
 
select * from jogadores;