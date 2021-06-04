<?php
if (isset($_SESSION["mensagem"])) {
?>
    <div class="mensagens">
        <p><?php echo $_SESSION["mensagem"]; ?></p>
    </div>
<?php
}
unset($_SESSION["mensagem"]);

?>
<header class="header">
    <link href="/icatalogo/componentes/header/header.css" rel="stylesheet" />
    <figure>
        <a href="/icatalogo/produtos">
            <img src="/icatalogo/imgs/logo.png" />
        </a>
    </figure>
    <form action="/icatalogo/produtos/" method="GET">
        <input type="text" value="<?= isset($_GET["pesquisar"]) ? $_GET["pesquisar"] : "" ?>" name="pesquisar" id="pesquisar" placeholder="Pesquisar" />
        <button <?= isset($_GET["pesquisar"]) && $_GET["pesquisar"] != "" ? "onClick='limparFiltro()'" : ""?> >
            <?php
            if (isset($_GET["pesquisar"]) && $_GET["pesquisar"] != "") {
            ?> 
            <img src="/icatalogo/imgs/close.svg" alt="" srcset="">
            <?php
            }else {

             ?>
                <img src="/icatalogo/imgs/lupa.svg">
            <?php
            }
            ?>

        </button>
    </form>
    <?php
    if (!isset($_SESSION["usuarioId"])) {
    ?>
        <nav>
            <ul>
                <a id="menu-admin">Administrar</a>
            </ul>
        </nav>
        <div id="container-login" class="container-login">
            <h1>Fazer Login</h1>
            <form method="POST" action="/icatalogo/componentes/header/acoesLogin.php">
                <input type="hidden" name="acao" value="login" />
                <input type="text" name="usuario" placeholder="Usuário" />
                <input type="password" name="senha" placeholder="Senha" />
                <button>Entrar</button>
            </form>
        </div>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <a id="menu-admin" onclick="logout()">Sair</a>
            </ul>
        </nav>
        <form id="form-logout" style="display:none" method="POST" action="/icatalogo/componentes/header/acoesLogin.php">
            <input type="hidden" name="acao" value="logout" />
        </form>
    <?php
    }
    ?>
</header>
<script lang="javascript">
    setTimeout(() => {
        document.querySelector('.mensagens').style.display = 'none';
    }, 5000);

    document.querySelector("#menu-admin").addEventListener("click", toggleLogin);

    function logout() {
        document.querySelector("#form-logout").submit();
    }

    function toggleLogin() {
        let containerLogin = document.querySelector("#container-login");
        let h1Form = document.querySelector("#container-login > h1");
        let form = document.querySelector("#container-login > form");
        //se estiver oculto, mostra 
        if (containerLogin.style.opacity == 0) {
            h1Form.style.display = "block";
            form.style.display = "flex";
            containerLogin.style.opacity = 1;
            containerLogin.style.height = "200px";
            //se não, oculta
        } else {
            h1Form.style.display = "none";
            form.style.display = "none";
            containerLogin.style.opacity = 0;
            containerLogin.style.height = "0px";
        }
    }
    function limparFiltro(){
        document.querySelector("#pesquisar").value = ""
    }
</script>