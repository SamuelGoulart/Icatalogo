<?php

session_start();

require("../database/conexao.php");


if (empty($_GET["pesquisar"])) {

    $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id
    ORDER BY p.id DESC;";
} else {

    $pesquisar = $_GET["pesquisar"];

    $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id
    WHERE p.descricao LIKE '%" . $pesquisar . "'
    OR c.descricao LIKE '%" . $pesquisar . "'
    ORDER BY p.id DESC; ";
}

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
                while ($produto = mysqli_fetch_array($resultado)) {
                ?>
                    <article class="card-produto">
                        <figure>
                            <img src="fotos/<?= $produto['imagem']  ?>" />
                            <?php
                            if (isset($_SESSION["usuarioId"])) {
                            ?>
                                <img onclick="deletar(<?= $produto['id'] ?>)" class="iconeLixeiraApagarProduto" src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" alt="">
                            <?php
                            }
                            ?>
                            <form id="form-deletar" action="./novo/produtosAcao.php" method="POST">
                                <input type="hidden" name="acao" value="deletar"></input>
                                <input type="hidden" id="produtoId" name="produtoId"></input>
                                <input type="hidden" value="../fotos/<?=$produto['imagem']?>" name="caminhoImagem"></input>
                            </form>
                        </figure>
                        <section>
                            <?php
                            $desconto =  $produto["desconto"];
                            $valor = $produto["valor"];

                            $valorFinal = ($desconto > 0) ? $valor - $valor * $desconto / 100 : $valor;

                            $qtdParcelas = $valorFinal > 1000 ? 12 : 6;
                            $valorParcela = $valorFinal / $qtdParcelas;

                            ?>
                            <span class="preco">
                                <?= $valor > 999 ? number_format($valorFinal, 2)  : str_replace(".", ",", $valorFinal);  ?> <em><?= $desconto ?>% off </em>
                            </span>

                            <span class="parcelamento">ou em <em><?= $qtdParcelas ?> x
                                    <?= number_format($valorParcela, 2, ",", ".") ?> sem juros</em></span>

                            <span class="descricao"><?= $produto["descricao"] ?></span>
                            <span class="categoria">
                                <em><?= $produto["categoria"]  ?></em>
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

    <script lang="javascript">
        function deletar(produtoId) {
            document.querySelector('#produtoId').value = produtoId
            document.querySelector('#form-deletar').submit();
        }

        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('animate')
        }, 500);

        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('displayNome')
        }, 5000);
    </script>
</body>

</html>