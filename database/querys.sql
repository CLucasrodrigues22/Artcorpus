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

create table contato (
    `id` int not null primary key auto_increment,
    `cep` varchar(10) not null,
    `logradouro` varchar(100) not null,
    `complemento` varchar(100) not null, 
    `bairro` varchar(100) not null,
    `numero` varchar(10) not null,
    `cidade` varchar(100) not null,
    `uf` varchar(100) not null,
    `localizacao` varchar(500) not null,
    `instagram` varchar(100) not null,
    `whatsapp` varchar(100) not null,
    `email` varchar(100) not null 
);

create table slide (
    `id` int not null primary key auto_increment,
    `imagem` varchar(100) not null,
    `titulo` varchar (20) not null,
    `descricao` varchar(50) not null
);