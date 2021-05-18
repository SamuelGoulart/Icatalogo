<?php

if (!isset($_SESSION["usuarioId"])) {

    $_SESSION["mensagem"] = " Você precisa fazer login para acessar essa página.";
    header('Location: ../index.php');
}
