create database icatalogo;

use icatalogo;

create table tbl_produto(
    id int primary key auto_increment,
    descricao varchar(255) not null,
    peso decimal not null,
    quantidade int not null,
    cor varchar(100) not null,
    tamanho varchar(100),
    valor decimal not null,
    desconto int,
    imagem varchar(500)
<<<<<<< HEAD
);


create table tbl_administrador(
   id int primary key auto_increment,
   nome varchar(100) not null,
   usuario varchar(255) not null,
   senha varchar (255) not null
);

insert into tbl_administrador (nome, usuario, senha) values ("Fulano de T
al","fulano","123456"); 

insert into tbl_administrador (nome, usuario, senha) values ("Ciclano da
Silva","ciclano","654321"); 


create table tbl_categoria (
    id int primary key auto_increment,
    descricao varchar(255) not null
);

insert into tbl_categoria(descricao) value ('Acessórios');
=======
);
>>>>>>> 827a1353892c2c4248ee9540dcb1ceaf290ef914
