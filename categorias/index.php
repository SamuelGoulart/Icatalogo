<?php


require("../database/conexao.php");

$query = " SELECT * FROM tbl_categoria ";

$resultado = mysqli_query($conexao, $query) or die(mysqli_error($conexao));


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./categorias.css" />
    <title>Administrar Categorias</title>
</head>

<body>

    <?php
    include("../componentes/header/header.php");
    ?>

    <div class="content">
        <div style="position: absolute; top: 0; right: 0;">
            <?php
            if (isset($_SESSION["erros"])) {
            ?>
                <p id="mensagem" data-anime="right"><?php echo $_SESSION["erros"]; ?></p>

            <?php
            }
            if (isset($_SESSION["mensagem"])) {
            ?>

                <p id="mensagem" data-anime="right"><?php echo $_SESSION["mensagem"]; ?></p>

            <?php
            }
            unset($_SESSION["erros"]);
            unset($_SESSION["mensagem"]);
            ?>
        </div>

        <section class="categorias-container">
            <main>
                <form class="form-categoria" action="./categoriasAcao.php" method="POST">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <input type="hidden" name="acao" value="inserir">
                    <div class="input-group span2">
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" />
                    </div>
                    <button type="button" onclick="javascript:window.location.href = '../produtos/'">Cancelar</button>
                    <button>Salvar</button>
                </form>
                <h1>Lista de Categorias</h1>
                <?php
                while ($categorias = mysqli_fetch_array($resultado)) {
                ?>
                    <div class="card-categorias" style="max-height: 48px;" >
                        <?= $categorias["descricao"]; ?>
                        <form action="./categoriasAcao.php" method="POST">
                            <input type="hidden" name="acao" value="deletar"></input>
                            <input type="hidden" name="categoriaId" value="<?= $categorias["id"] ?>"></input>
                            <button >
                                <img src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />
                            </button>
                        </form>
                    </div>
                <?php
                }
                ?>
            </main>
        </section>
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('animate')
        }, 1000);

        setTimeout(() => {
            document.querySelector('#mensagem').classList.add('displayNome')
        }, 5000);
    </script>
</body>

</html>