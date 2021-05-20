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

    //Verificar se o campo está vindo e se ele é uma imagem
    if ($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE) {
        $erros[] = "O campo foto é obrigatório";
    } elseif (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] != UPLOAD_ERR_OK) {
        $erros[] = "Ops, houve um erro inesperado. Verifique o arquivo e tente novamente. ";
    }else{
        $imagemInfo = getimagesize($_FILES["foto"]["tmp_name"]);

        if (!$imagemInfo) {
            $erros[] = "Este arquivo não é uma imagem";
        }

        if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
            $erros[] = "O arquivo não pode ser maior que 2MB";
        }

        //Se a imagem
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
        
        $fileName = $_FILES["foto"]["name"];

        $extensao = pathinfo($fileName, PATHINFO_EXTENSION);
                
        $newFileName = md5(microtime()). ".$extensao";

        move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/$newFileName");

        $descricao = $_POST["descricao"];
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;

        $sqlInsert = " INSERT INTO  tbl_produto (descricao ,peso , quantidade, cor, tamanho, valor, desconto, imagem) VALUES ('$descricao', $peso, $quantidade,'$cor','$tamanho', $valor,'$desconto','$newFileName') ";

        $resultadoInsert = mysqli_query($conexao, $sqlInsert);
       
        header("location: index.php");


        break;
}
