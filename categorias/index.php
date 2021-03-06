<?php

session_start();

require("../database/conexao.php");

$sql = " SELECT * FROM tbl_categoria ";

$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));


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
                if (mysqli_num_rows($resultado) == 0) {
                    echo "<p style='text-align: center'> Nenhuma categoria cadastrada.</p>";
                }
                while ($categorias = mysqli_fetch_array($resultado)) {
                ?>
                    <div class="card-categorias">
                        <?= $categorias["descricao"]; ?>
                        <img onclick="deletar(<?= $categorias['id'] ?>)" style="width: 20px;" src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />

                    </div>
                <?php
                }
                ?>
                <form id="form-deletar" action="./categoriasAcao.php" method="POST">
                    <input type="hidden" name="acao" value="deletar"></input>
                    <input type="hidden" id="categoriaId" name="categoriaId" value="" ></input>
                </form>
            </main>
        </section>
    </div>

    <script lang="javascript" >
           function deletar(catagoriaId){
               document.querySelector('#categoriaId').value = catagoriaId
               document.querySelector('#form-deletar').submit();
           }
    </script>

</body>

</html>