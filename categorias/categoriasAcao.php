<?php

session_start();

require("../database/conexao.php");

function validaCampos(){
    $erros = [];

    if (!isset($_POST["descricao"]) || $_POST["descricao"] == "") {
            $erros[] = "O campo descrição é obrigatório";
    }

    return $erros;
}


switch ($_POST["acao"]) {
    case 'inserir':

        $erros = validaCampos();

        if (count($erros) > 0) {
            $_SESSION["erros"] = $erros;
            header("location: index.php");
            exit();
        }

        $descricao = $_POST["descricao"];

        $sql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao'); ";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $_SESSION["mensagem"] = "Categoria " . $descricao . " adicionado com sucesso! ";
        }else{
            $_SESSION["mensagem"] = "Ops, houve algum erro";
        }

    case "deletar":
        if (isset($_POST["categoriaId"]) && $_POST["categoriaId"] != "") {

            $categoriaId = $_POST["categoriaId"];

            $sqlDelete = "DELETE FROM tbl_categoria  WHERE id=$categoriaId";

            $resultadoDelete  = mysqli_query($conexao, $sqlDelete);

            if ($resultadoDelete) {
                $_SESSION["mensagem"] = "Categoria deletada com sucesso";
            }else{
                $_SESSION["mensagem"] = "Ops, erro ao excluir";
            }
        }

    default:

        header("location: index.php");

        break;
}
