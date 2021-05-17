<?php

session_start();

require("../database/conexao.php");


switch ($_POST["acao"]) {
    case 'inserir':

        if (isset($_POST["descricao"]) && $_POST["descricao"] == "") {

            $erros = "O campo descrição é obrigatório";
            $_SESSION["erros"] = $erros;
            header("location: index.php");
            break;
        }

        $descricao = $_POST["descricao"];

        $sql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao'); ";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {

            $_SESSION["mensagem"] = "Categoria " . $descricao . " adicionado com sucesso! ";
        }

        break;
    case "deletar":
        if (isset($_POST["categoriaId"]) && $_POST["categoriaId"] != "") {

            $categoriaId = $_POST["categoriaId"];

            $sqlDelete = "DELETE FROM tbl_categoria  WHERE id=$categoriaId";

            $resultadoDelete  = mysqli_query($conexao, $sqlDelete);
        }

    default:

        header("location: index.php");

        break;
}
