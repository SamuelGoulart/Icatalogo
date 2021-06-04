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
    } else {
        $imagemInfo = getimagesize($_FILES["foto"]["tmp_name"]);

        if (!$imagemInfo) {
            $erros[] = "Este arquivo não é uma imagem";
        }

        if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
            $erros[] = "O arquivo não pode ser maior que 2MB";
        }

        //Pega a largura é altura da imagem
        list($width, $height) = $imagemInfo;
        // Verifica se é quadrada
        if ($width != $height) {
            $erros[] = "A imagem precisa ser quadrada";
        }
    }

    if (!isset($_POST["categoria"]) && $_POST["categoria"] == "") {
        $erros[] = "O campo categoria é obrigatória";
    }

    return $erros;
}
function validarCamposEditar()
{
    //declara um vetor de erros
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
    //validar se o campo quantidade está preenchido
    if (!isset($_POST["quantidade"]) && $_POST["quantidade"] == "") {
        $erros[] = "O campo quantidade é obrigatório";
        //validar se o campo quantidade é um número
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
    //se o campo desconto veio preenchido, testa se ele é numérico
    if (isset($_POST["desconto"]) && $_POST["desconto"] != "" && !is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
        $erros[] = "O campo desconto deve ser um número";
    }
    //se houver um arquivo de foto
    if ($_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE) {
        //se o arquivo é uma imagem
        $imagemInfos = getimagesize($_FILES["foto"]["tmp_name"]);
        //se não for uma imagem
        if (!$imagemInfos) {
            $erros[] = "O arquivo precisa ser uma imagem";
        }
        //se a imagem for maior que 2MB
        if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
            $erros[] = "O arquivo não pode ser maior que 2MB";
        }
        //se a imagem não for quadrada [[[--DESAFIO--]]]
        //se a largura e a altura forem iguais, a imagem é quadrada
        $width = $imagemInfos[0];
        $height = $imagemInfos[1];
        if ($width != $height) {
            $erros[] = "A imagem precisa ser quadrada";
        }
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
            header("location: ./index.php");

            exit();
        }

        $fileName = $_FILES["foto"]["name"];

        $extensao = pathinfo($fileName, PATHINFO_EXTENSION);

        $newFileName = md5(microtime()) . ".$extensao";

        move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/$newFileName");

        $descricao = $_POST["descricao"];
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;
        $categoriaId = $_POST["categoria"];

        echo $valor;


        $sqlInsert = " INSERT INTO  tbl_produto (descricao ,peso , quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) VALUES ('$descricao', $peso, $quantidade,'$cor','$tamanho', $valor,'$desconto','$newFileName', '$categoriaId') ";

        $resultadoInsert = mysqli_query($conexao, $sqlInsert);

        if ($resultadoInsert) {
            $mensagem = "Produto inserido com sucesso";
        } else {
            $mensagem = "Erro ao inserir o produto!";
        }

        $_SESSION["mensagem"] = $mensagem;

        header("location: index.php");

        break;

    case 'deletar':

        //Buscamos o nome da foto do produto no banco de dados
        $produtoId = $_POST["produtoId"];
        $sql = " SELECT imagem FROM tbl_produto WHERE id = $produtoId ";
        $resultado = mysqli_query($conexao, $sql);
        $produto = mysqli_fetch_array($resultado);

        //deletamos a imagem da pasta fotos
        unlink("../fotos/" . $produto["imagem"]);

        $sqlDelete = "DELETE FROM tbl_produto WHERE id = $produtoId; ";
        unlink("../fotos/$caminhoImagem");

        $resultadoDelete  = mysqli_query($conexao, $sqlDelete);

        if ($resultadoDelete) {
            $_SESSION["mensagem"] = "Produto deletada com sucesso";
        } else {
            $_SESSION["mensagem"] = "Ops, erro ao excluir o produto";
        }

        header("location: ../index.php");

    case "editar":

        $erros = validarCamposEditar();

        if (count($erros) > 0) {
            $_SESSION["erros"] = $erros;

            header("location: ../index.php");
        }

        $produtoId = $_POST["produtoId"];

        //se 
        if ($_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE) {
            //salvar a imagem nova
            $sql = " SELECT imagem FROM tbl_produto WHERE id = $produtoId ";
            $resultado = mysqli_query($conexao, $sql);
            $produto = mysqli_fetch_array($resultado);

            unlink("../fotos/" . $produto["imagem"]);

            $fileName = $_FILES["foto"]["name"];

            $extensao = pathinfo($fileName, PATHINFO_EXTENSION);

            $newFileName = md5(microtime()) . ".$extensao";

            move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/$newFileName");
        }

        $descricao = $_POST["descricao"];
        $peso = str_replace(",", ".", $_POST["peso"]);
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = str_replace(",", ".", $_POST["valor"]);
        $desconto = $_POST["desconto"] != "" ? $_POST["desconto"] : 0;
        $categoriaId = $_POST["categoria"];
       
        $sqlUpdate = " UPDATE tbl_produto SET descricao = '$descricao', peso = $peso, quantidade = $quantidade, cor = '$cor', tamanho = $tamanho, valor = $valor, desconto = $desconto, categoria_id = '$categoriaId'";


        //Caso tenha um novo sw arquivo, setamos no banco de dados
        $sqlUpdate .= $newFileName ? ", imagem = '$newFileName' " : "";
        $sqlUpdate .= " WHERE id = $produtoId; ";

        $resultado = mysqli_query($conexao, $sqlUpdate);

        if ($resultado) {
            $mensagem = "Produto editado com sucesso!";
        } else {
            $mensagem = "Ops, problema ao editar o produto.";
        }

        $_SESSION["mensagem"] = $mensagem;

        header("location: ../index.php");

        break;
}
