<?php

session_start();

require("../database/conexao.php");

$sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
INNER JOIN tbl_categoria c ON p.categoria_id = c.id
ORDER BY p.id DESC;";


$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./produtos.css" />
    <title>Administrar Produtos</title>
</head>

<body>
    <?php
    include("../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="produtos-container">
            <?php
            //autorização

            //se o usuário estiver logado, mostrar os botões
            if (isset($_SESSION["usuarioId"])) {
            ?>
                <header>
                    <a href="./novo/"> <button>Novo Produto</button> </a>
                    <a href="../categorias/"> <button>Adicionar Categoria</button> </a>
                </header>
            <?php
            }
            ?>
            <main>
                <?php
                while ($informacoesProduto = mysqli_fetch_array($resultado)) {
                ?>
                    <article class="card-produto">
                        <figure>
                            <img src="fotos/<?= $informacoesProduto['imagem']  ?>" />
                        </figure>
                        <section>
                            <span class="preco"><?= str_replace(".", ",", $informacoesProduto["valor"]); ?></span>
                            <?php
                                 if ($informacoesProduto["valor"] > 999) {
                                    $parcelamento = 12;
                                 }else{
                                    $parcelamento = 6;
                                 }
                            ?>
                            <span class="parcelamento">ou em <em><?= $parcelamento ?> x <?= str_replace(".", ",", $informacoesProduto["valor"]); ?> sem juros</em></span>

                            <span class="descricao"><?= $informacoesProduto["descricao"] ?></span>
                            <span class="categoria">
                                <em><?= $informacoesProduto["categoria"]  ?></em>
                            </span>
                        </section>
                        <footer>

                        </footer>
                    </article>

                <?php
                }
                ?>
            </main>
        </section>
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>

    <script>
        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('animate')
        }, 500);

        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('displayNome')
        }, 5000);
    </script>
</body>

</html>