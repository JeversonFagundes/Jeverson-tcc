<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>

</head>

<body>

    <!--INDEX.PHP-->

    <!--Esta é a tela de login dos usuários do sistema.-->

    <main>
        <h1>Tela de login</h1>

        <?php

        //incluir o arquivo que exibe as mensagens para o usuário
        require_once "boasPraticas/notificacoes.php";
        ?>

        <form action="login.php" method="post">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
                <span class="helper-text" data-error="O campo deve ser preenchido no formato XXX.XXX.XXX-XX"></span>
            </div>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required><br>

            <ul>
                <li><a href="recuperarSenha/form-recuperar-senha.html">Esqueci minha senha</a></li>
                <li><a href="crudAluno/formcadAluno.php">Não possui conta? Clique aqui!</a></li>
            </ul>

            <button type="submit">Entrar</button>
        </form>


    </main>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>