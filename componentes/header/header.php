
<link href="/icatalogo/componentes/header/header.css" rel="stylesheet" />
<div class="mensagens">
    <?php
    if (isset($_SESSION["erros"])) {
        foreach ($_SESSION["erros"] as $erro) {
    ?>
            <p><?php echo $erro ?></p>
        <?php
        }
    }
    if (isset($_SESSION["mensagem"])) {
        ?>
        <p><?php echo $_SESSION["mensagem"]; ?></p>
    <?php
    }
    unset($_SESSION["erros"]);
    unset($_SESSION["mensagem"]);
    ?>
</div>
<header class="header">
    <figure>
        <img src="/icatalogo/imgs/logo.png" />
    </figure>
    <input type="search" placeholder="Pesquisar" />
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
        document.querySelector('.mensagens').style.display = 'none'
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
</script>