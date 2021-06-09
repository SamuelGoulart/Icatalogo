<h1  align="center" >iCatalogo</h1>

<br>

<h2>📕 Indice</h2>

<ul>
  <li>Sobre o projeto</li>
  <li>Tecnologias utilizadas</li>
  <li>Ferramentas</li>
  <li>O que eu aprendi</li>
  <li>Clone do projeto</li>
</ul>

<h2>💻Sobre o projeto</h2>

Catálogo para divulgação de produtos.

Projeto com foco no back-end.

Projeto desenvolvido durante o curso de técnico em desenvolvimento de sistemas.
 
<h2>🚀 Tecnologias utilizadas</h2>

<ul>
  <li>HTML</li>
  <li>CSS</li>
  <li>JavaScript</li>
  <li>PHP</li>
</ul>

<h2>🔧 Ferramentas</h2>
<ul>
  <li>MySQL</li>
  <li>xampp</li>
  <li>Visual Studio Code</li>
</ul>

<h2><img width="30" src="https://user-images.githubusercontent.com/62961331/119981069-91137000-bf93-11eb-9d7b-fcc91896dbf7.png"> O que eu aprendi</h2>

<ul>
  <li>CRUD</li>
     <ul>
       <li>Create (criar) - criar um novo registro.</li>
       <li>Read (ler) - ler (exibir) as informações das tabelas.</li>
       <li>Update (atualizar) - atualizar os dados do registro.</li>
       <li>Delete (apagar) - apagar um registro.</li>
     </ul>
  <li>Fazer o login e logout</li>
  <li>Upload de imagem</li>
  <li>Filtro de pesquisa</li>
  <li>Relacionamentos entre tabelas</li>
  <li>Salvar senha criptografada e sua importância</li>
</ul>


## 🚀 Clone do projeto

Para iniciar, clone o projeto para dentro da sua pasta htdocs.

~~~

https://github.com/SamuelGoulart/Icatalogo

~~~

<!-- ### 📋 Tarefa -->

<!-- Você deve implementar o cadastro de produtos na tela /produtos/novo/index.php -->

### 💾 Criação do Banco de Dados

O arquivo para criar a estrutura do banco está em /database/ddl.sql
<br>
Copie, cole e execute o código no seu Mysql Workbench
~~~
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
);

ALTER TABLE tbl_produto ADD COLUMN categoria_id INT, ADD FOREIGN KEY (categoria_id) REFERENCES tbl_categoria(id);

create table tbl_administrador(
   id int primary key auto_increment,
   nome varchar(100) not null,
   usuario varchar(255) not null,
   senha varchar (255) not null
);

create table tbl_categoria (
    id int primary key auto_increment,
    descricao varchar(255) not null
);

insert into tbl_administrador (nome, usuario, senha) values ("Fulano de T
al","fulano","$2y$10$Pww8WY7k3Nb2E2PNC8dygeY.A7P2/4lx3NSi3RuhwXSTSWA3/yYMe"); 
~~~

## Observação:
Para fazer login use:<br>
 Usuário: fulano <br>
 Senha : 123456

Se por ventura dar algum erro no login, acesse o aquivo senhas.php, através do navegador.
Copie a senha criptografada que aparecer, vá até o Mysql Workbench, e atualize o campo senha da tabela tbl_administrador com a nova senha.
