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
                            <?php
                            $desconto =  $informacoesProduto["desconto"];
                            $valor = $informacoesProduto["valor"];
                            $valorComDesconto = $valor - $valor * $desconto / 100;

                            $qtdParcelas = $valorComDesconto > 1000 ? 12 : 6;
                            $valorParcela = $valorComDesconto / $qtdParcelas;

                            ?>
                            <span class="preco">
                                <p style="text-decoration: line-through; font-size: 1rem;"><?= $valor ?></p> <?= $valor > 999 ? number_format($valorComDesconto, 2)  : str_replace(".", ",", $valorComDesconto) ; ?>
                            </span>

                            <span class="parcelamento">ou em <em><?= $qtdParcelas ?> x <?= 
                            number_format($valorParcela, 2, ",", ".") ?> sem juros</em></span>



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