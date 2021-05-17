<?php

//inicializa a sessão no php
//todo arquivo que se ultizar sessão, precisa chamar a session_start()
session_start();

function validarCampos()
{
    $erros = [];

    //validar se campo descricao está preenchido
    if (!isset($_POST["descricao"]) && $_POST["descricao"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }

    //validar se o campo peso está preenchido
    if (!isset($_POST["peso"]) && $_POST["peso"] == "") {
        $erros[] = "O campo peso é obrigatório";
        //validar se o campo peso é um número
    } elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
        $erros[] = "O campo peso deve ser um número";
    }

    if (!isset($_POST["quantidade"]) && $_POST["quantidade"] == "") {
        $erros[] = "O campo quantidade é obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
        $erros[] = "O campo quantidade deve ser um número";
    }

    if (!isset($_POST["cor"]) && $_POST["cor"] == "") {
        $erros[] = "O campo cor é obrigatório";
    }

    if (!isset($_POST["valor"]) && $_POST["valor"] == "") {
        $erros[] = "O campo valor é obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {
        $erros[] = "O campo valor deve ser um número";
    }

    return $erros;
}

require("../../database/conexao.php");

switch ($_POST["acao"]) {
    case 'inserir':
        //chamamos a função de validação para verificicar se tem erros
        $erros = validarCampos();

        //se houver erros
        if (count($erros) > 0) {

            //incluímos um campo erros na sessão e atribuímos o vetor de erros a ele
            $_SESSION["erros"] = $erros;

            //redirecionar para a página do formulário
            header("location: ../index.php=?erros=$erros");
        }
        $descricao = $_POST["descricao"];
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;
        $imagem = "http://3.bp.blogspot.com/-u34_1MW1w5g/T_eNqYLmtFI/AAAAAAAAEP0/jnssgMNcS8Y/s1600/converse-all-star-dark-blue.png";


        $sqlInsert = " INSERT INTO  tbl_produto (descricao ,peso , quantidade, cor, tamanho, valor, desconto, imagem) VALUES ('$descricao', $peso, $quantidade,'$cor','$tamanho', $valor,'$desconto','$imagem') ";

        $resultadoInsert = mysqli_query($conexao, $sqlInsert);

        if ($resultado) {
            $mensagem = "Produto inserido com sucesso!";
        } else {
            $mensagem = "Erro ao inserir o produto!";
        }

        header("location: index.php");
        break;
}
