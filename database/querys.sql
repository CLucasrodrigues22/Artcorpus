create table usuarios (
    `id` int not null primary key auto_increment,
    `nome` varchar(100) not null,
    `usuario` varchar(50) not null,
    `senha` varchar(250) not null,
    `imagem` varchar(100)
);

create table servicos (
    `id` int not null primary key auto_increment,
    `nome` varchar(50) not null,
    `imagem` varchar(100)
);

